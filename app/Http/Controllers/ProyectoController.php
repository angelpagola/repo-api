<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeProyecto;
use App\Http\Requests\updateProyecto;
use App\Models\Favorito;
use App\Models\Proyecto;
use App\Models\ProyectoArchivo;
use App\Models\ProyectoImagen;
use App\Models\ProyectoTag;
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
    public function index(Request $request, $usuario)
    {
        $user = Usuario::query()->where('usuario', $usuario)->first();
        $search = $request->get('buscar') ?? "";

        if (!$user) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'No existe ningún usuario con este id en el sistema.'
            ], 200);
        }

        $proyecto = Proyecto::query()
            ->select('id', 'uuid', 'titulo', 'fecha_publicacion', 'estudiante_id')
            ->with('estudiante:id,apellidos,nombres,avatar', 'estudiante.usuario:id,usuario,estudiante_id', 'portada:id,link_imagen,proyecto_id')
            ->with(['tags' => function ($query) {
                $query->limit(4);
            }])
            ->where('titulo', 'like', '%' . $search . '%')
            ->where('estudiante_id', $user->estudiante_id)
            ->orderBy('fecha_publicacion', 'desc')
            ->get();

        if (count($proyecto)) {
            return response()->json([
                'respuesta' => true,
                'mensaje' => $proyecto
            ], 200);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'No se encontró ningún proyecto.'
            ], 200);
        }
    }

    public function show($proyecto_id)
    {
        $proyecto = Proyecto::query()
            ->with('estudiante', 'estudiante.usuario', 'estudiante.escuela', 'tags', 'portadas', 'proyectoArchivo')
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
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error de validación', 'error' => $validator->errors()
            ], 200);
        }

        $usuario = Usuario::find($request->usuario_id);

        $proyecto = Proyecto::create([
            'uuid' => Str::uuid(),
            'titulo' => $request->titulo,
            'resumen' => $request->resumen,
            'fecha_publicacion' => now()->format('Y-m-d'),
            'estudiante_id' => $usuario->estudiante_id
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
        $documentos_ids = [];
        foreach ($request->documentos as $documento) {
            $nombreDoc = 'repotweb_' . time() . rand(1, 99) . '.' . $documento->getClientOriginalExtension();
            $link_doc = asset($urlDocumentos . $nombreDoc);
            $documento->storeAs($rutaDocumentos, $nombreDoc);
            $documentos_ids[] = ["link_archivo" => $link_doc, "proyecto_id" => $proyecto->id];
        }
        ProyectoArchivo::insert($documentos_ids);

        return response()->json([
            'respuesta' => true,
            'mensaje' => 'Registro Creado Correctamente'
        ], 201);
    }

    public function update(updateProyecto $request, Proyecto $proyecto)
    {
        $proyecto->update($request->all());
        return response()->json([
            'respuesta' => true,
            'mensaje' => 'Registro Actualizado Correctamente'
        ], 201);
    }

    public function destroy($id)
    {
        $proyecto = Proyecto::destroy($id);
        if (is_null($proyecto)) {
            return response()->json(['mensaje' => 'Proyecto No Encontrado'], 404);
        }
        return response()->json(null, 204);
    }

    public function recomendados($proyecto_id)
    {
        $proyectos = Proyecto::query()
            ->select('id', 'titulo', 'estudiante_id')
            ->addSelect([
                'similitud' => ProyectoTag::select(DB::raw('count(*)'))
                    ->whereColumn('proyecto_id', 'proyectos.id')
                    ->whereIn('tag_id', function ($query) use ($proyecto_id) {
                        $query->select('tag_id')->from('proyecto_tags')->where('proyecto_id', $proyecto_id);
                    })
                    ->take(1)
            ])
            ->with('portada', 'estudiante:id', 'estudiante.usuario:usuario,estudiante_id')
            ->having('id', '<>', $proyecto_id)
            ->orderBy('similitud', 'desc')
            ->orderBy('fecha_publicacion', 'desc')
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

    // Obtener los datos basicos del usuario: avatar, nombres, contacto
    public function datosUsuario($usuario)
    {
        $user = Usuario::query()
            ->with(['estudiante' => function ($query) {
                $query->withCount('proyecto');
            }, 'estudiante.escuela'])
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
}
