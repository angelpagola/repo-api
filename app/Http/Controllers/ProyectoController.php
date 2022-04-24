<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeProyecto;
use App\Http\Requests\updateProyecto;
use App\Models\Comentario;
use App\Models\Favorito;
use App\Models\Motivo;
use App\Models\Proyecto;
use App\Models\ProyectoArchivo;
use App\Models\ProyectoImagen;
use App\Models\ProyectoTag;
use App\Models\Reporte;
use App\Models\Tag;
use App\Models\Usuario;
use App\Models\Valoracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProyectoController extends Controller
{
    // TODO: Ok
    public function index(Request $request, $usuario)
    {
        $user = Usuario::query()->where('usuario', $usuario)->first();
        $search = $request->get('buscar') ?? "";

        if (!$user) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'No existe ningún usuario con este nombre en el sistema.'
            ]);
        }

        $proyecto = Proyecto::query()
            ->select('id', 'titulo', 'created_at', 'usuario_id')
            ->with('usuario:id,usuario,avatar', 'portada:id,link_imagen,proyecto_id')
            ->with(['tags' => function ($query) {
                $query->limit(4);
            }])
            ->where('titulo', 'like', '%' . $search . '%')
            ->where('usuario_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        if (count($proyecto)) {
            return response()->json([
                'respuesta' => true,
                'mensaje' => $proyecto
            ]);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'No se encontró ningún proyecto.'
            ]);
        }
    }

    // TODO: Ok
    public function show($proyecto_id)
    {
        $proyecto = Proyecto::query()
            ->with('usuario', 'usuario.estudiante', 'usuario.estudiante.escuela', 'tags', 'portadas', 'archivos')
            ->with(['reportes' => function ($query) {
                $query->select('usuario_id', 'proyecto_id')->orderBy('motivo_id');
            }])
            ->where('id', $proyecto_id)
            ->first();

        if (is_null($proyecto)) {
            return response()->json(['mensaje' => 'Proyecto No Econtrado'], 404);
        }
        return response()->json($proyecto, 200);
    }

    public function store(Request $request)
    {
        $rules = [
            "titulo" => "required|max:255",
            "resumen" => "required",
            'usuario_id' => "required|gt:0",
            'tags' => 'required|array|min:2',
            "imagenes" => "required",
            "imagenes.*" => "image|mimes:png,jpeg,jpg",
            "documentos" => "required",
            "documentos.*" => "mimes:pdf,docx,xlsx",
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['respuesta' => false, 'mensaje' => 'Error de validación', 'error' => $validator->errors()]);
        }

        $usuario = Usuario::find($request->usuario_id);

        $proyecto = Proyecto::create([
            'uuid' => Str::uuid(),
            'titulo' => $request->titulo,
            'resumen' => $request->resumen,
            'usuario_id' => $usuario->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $tags_id = [];
        foreach ($request->tags as $tag) {
            $tag = substr($tag, 0, 30);
            $tag_exists = Tag::query()->where('nombre', $tag)->first();
            if (!$tag_exists) {
                $tag_exists = Tag::create(['nombre' => $tag]);
            }
            $tags_id[] = $tag_exists->id;
        }

        $usuario->intereses()->attach($tags_id);
        $proyecto->tags()->attach($tags_id);

        $rutaImagenes = 'public/proyectos/imagenes';
        $urlImagenes = 'storage/proyectos/imagenes/';
        if (!Storage::exists($rutaImagenes)) {
            Storage::makeDirectory($rutaImagenes);
        }
        $imagenes_ids = [];
        foreach ($request->imagenes as $imagen) {
            $nombreImagen = 'repotweb_' . time() . rand(1, 99) . '.' . $imagen->getClientOriginalExtension();
            $link_imagen = asset($urlImagenes . $nombreImagen);
            $imagen->storeAs($rutaImagenes, $nombreImagen);
            $imagenes_ids[] = ["link_imagen" => $link_imagen, "proyecto_id" => $proyecto->id];
        }
        ProyectoImagen::insert($imagenes_ids);

        $rutaDocumentos = 'public/proyectos/documentos';
        $urlDocumentos = 'storage/proyectos/documentos/';
        if (!Storage::exists($rutaDocumentos)) {
            Storage::makeDirectory($rutaDocumentos);
        }
        $docs = [];
        foreach ($request->documentos as $documento) {
            $nombreDoc = 'repotweb_' . time() . rand(1, 99) . '.' . $documento->getClientOriginalExtension();
            $link_doc = asset($urlDocumentos . $nombreDoc);
            $documento->storeAs($rutaDocumentos, $nombreDoc);
            $docs[] = ["nombre" => $nombreDoc, "link_archivo" => $link_doc, "proyecto_id" => $proyecto->id];
        }
        ProyectoArchivo::insert($docs);

        return response()->json([
            'respuesta' => true,
            'mensaje' => 'Registro creado correctamente'
        ], 201);
    }

    public function update(Request $request, $proyecto_id)
    {
        /*Por el momento aún no se pueden aditar los documentos e imagenes*/
        $rules = [
            "titulo" => "required|max:255",
            "resumen" => "required",
            'usuario_id' => "required|gt:0",
            'tags' => 'required|array|min:2',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error de validación', 'error' => $validator->errors()
            ], 200);
        }

        $usuario = Usuario::find($request->usuario_id);

        if (!$usuario) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'No existe ningún usuario con este id en el sistema.'
            ], 200);
        }

        $proyecto = Proyecto::find($proyecto_id);

        if (!$proyecto) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'No existe ningún proyecto con este id en el sistema.'
            ], 200);
        }

        $proyecto->update($request->all());

        $proyecto->update([
            'titulo' => $request->titulo,
            'resumen' => $request->resumen,
        ]);

        $tags_id = [];
        foreach ($request->tags as $tag) {
            $tag_exists = Tag::query()->where('nombre', $tag)->first();
            if (!$tag_exists) {
                $tag_exists = Tag::create(['nombre' => $tag]);
            }
            $tags_id[] = $tag_exists->id;
        }

        $usuario->intereses()->attach($tags_id);

        ProyectoTag::where('proyecto_id', $proyecto_id)->delete();
        $proyecto->tags()->attach($tags_id);

        return response()->json([
            'respuesta' => true,
            'mensaje' => 'Registro Actualizado Correctamente'
        ], 201);
    }

    /*Este proceso es irreversible*/
    public function destroy($proyecto_id)
    {
        $proyecto = Proyecto::find($proyecto_id);
        if (!$proyecto) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'No existe ningún proyecto con este id en el sistema.'
            ], 200);
        }

        Valoracion::where('proyecto_id', $proyecto_id)->delete();
        Favorito::where('proyecto_id', $proyecto_id)->delete();
        Comentario::where('proyecto_id', $proyecto_id)->delete();
        Reporte::where('proyecto_id', $proyecto_id)->delete();
        ProyectoTag::where('proyecto_id', $proyecto_id)->delete();
        ProyectoImagen::where('proyecto_id', $proyecto_id)->delete();
        ProyectoArchivo::where('proyecto_id', $proyecto_id)->delete();
        $proyecto->delete();

        return response()->json([
            'respuesta' => true,
            'mensaje' => 'Registro Eliminado Correctamente'
        ], 200);
    }

    // TODO: Ok
    public function recomendados($proyecto_id)
    {
        $proyectos = Proyecto::query()
            ->select('id', 'titulo', 'usuario_id')
            ->addSelect([
                'similitud' => ProyectoTag::select(DB::raw('count(*)'))
                    ->whereColumn('proyecto_id', 'proyectos.id')
                    ->whereIn('tag_id', function ($query) use ($proyecto_id) {
                        $query->select('tag_id')->from('proyecto_tags')->where('proyecto_id', $proyecto_id);
                    })
                    ->take(1)
            ])
            ->with('portada', 'usuario:id,usuario')
            ->having('id', '<>', $proyecto_id)
            ->orderBy('similitud', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return response()->json($proyectos, 200);
    }

    public function darLike($proy_id, $user_id)
    {
        $valoracion = Valoracion::query()->where('proyecto_id', $proy_id)->where('usuario_id', $user_id)->first();

        if ($valoracion) {
            $valoracion->delete();
        } else {
            Valoracion::create([
                "me_gusta" => true,
                "proyecto_id" => $proy_id,
                "usuario_id" => $user_id
            ]);
        }
    }

    // TODO: Ok
    public function valoracion($proyecto_id, $usuario_id)
    {
        $proyecto = Proyecto::query()
            ->select('id')
            ->addSelect([
                'por_usuario' => Valoracion::select('me_gusta')
                    ->whereColumn('proyecto_id', 'proyectos.id')
                    ->where('usuario_id', $usuario_id)
                    ->take(1)
            ])
            ->withCount(['likes', 'dislikes'])->find($proyecto_id);
        if ($proyecto)
            return response()->json($proyecto, 200);

        return response()->json([], 204);
    }

    // TODO: Ok
    // Para agregar o quitar un proyecto a Favoritos
    public function agregarAFav($proy_id, $user_id)
    {
        $fav = Favorito::query()->where('proyecto_id', $proy_id)->where('usuario_id', $user_id)->first();

        if ($fav) {
            $fav->delete();
        } else {
            Favorito::create([
                "fecha_agregacion" => now()->format('Y-m-d'),
                "proyecto_id" => $proy_id,
                "usuario_id" => $user_id
            ]);
        }
    }

    // TODO: Ok
    //Saber si un proyecto esta en los favoritos de un usuario
    public function favorito($proyecto_id, $usuario_id)
    {
        $proyecto = Proyecto::query()
            ->select('id')
            ->whereHas('favoritos', function ($query) use ($usuario_id) {
                $query->where('usuario_id', $usuario_id);
            })->find($proyecto_id);

        return response()->json(["es_favorito" => (bool)$proyecto], 200);
    }

    // TODO: Ok
    // Obtener los datos basicos del usuario: avatar, nombres, contacto
    public function datosUsuario($usuario)
    {
        $user = Usuario::query()
            ->with('estudiante', 'estudiante.escuela')
            ->withCount('proyectos')
            ->where('usuario', $usuario)->first();

        if (!$user) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'No existe ningún usuario con este id en el sistema.'
            ], 200);
        }

        return response()->json([
            'respuesta' => true,
            'mensaje' => $user
        ], 200);
    }

    // Funcion para reportar un proyecto, si ya alcanzo los 10 usuarios se elimina
    public function reportar(Request $request)
    {
        $rules = [
            'motivos' => 'required|array|min:1',
            'usuario_id' => "required|gt:0",
            'proyecto_id' => "required|gt:0",
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['respuesta' => false, 'mensaje' => 'Error de validación', 'error' => $validator->errors()]);
        }

        $proyecto = Proyecto::find($request->proyecto_id);

        if (!$proyecto) {
            return response()->json(['respuesta' => false, 'mensaje' => 'Error, este proyecto no existe.']);
        }

        $data = [];
        foreach ($request->motivos as $motivo) {
            $reporte_exists = Reporte::query()
                ->where('motivo_id', $motivo)
                ->where('usuario_id', $request->usuario_id)
                ->where('proyecto_id', $request->proyecto_id)
                ->exists();

            if (!$reporte_exists) {
                $data[] = ['motivo_id' => $motivo, 'usuario_id' => $request->usuario_id, 'proyecto_id' => $request->proyecto_id];
            }
        }

        if (count($data)) {
            Reporte::insert($data);
        }

        $veces_reportado = Reporte::query()->select('usuario_id')->distinct()
            ->where('proyecto_id', $request->proyecto_id)->get();
        $veces_reportado = count($veces_reportado);

        $estado = false;
        if ($veces_reportado >= 10) {
            $estado = true;
            $this->destroy($request->proyecto_id);
        }

        return response()->json([
            'respuesta' => $estado,
            'mensaje' => '¡Gracias por avisarnos! Si vemos que este contenido infringe nuestras Normas de la Comunidad, lo retiraremos.'
        ], 201);

    }

    // TODO: Ok
    // Lista de motivos para reportar un proyecto
    public function motivos()
    {
        $motivos = Motivo::query()->orderBy('nombre')->get();
        return response()->json($motivos, 200);
    }
}
