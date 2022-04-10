<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeProyecto;
use App\Http\Requests\updateProyecto;
use App\Models\Proyecto;
use App\Models\ProyectoTag;
use App\Models\Usuario;
use App\Models\Valoracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProyectoController extends Controller
{
    public function index(Usuario $usuario)
    {
        if (!$usuario) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'No existe ningún usuario con este id en el sistema.'
            ], 200);
        }

        $callback = Proyecto::query()
            ->select('id', 'uuid', 'titulo', 'fecha_publicacion', 'estudiante_id')
            ->with('estudiante:id,apellidos,nombres,avatar', 'estudiante.usuario:usuario,estudiante_id', 'portada:id,link_imagen,proyecto_id', 'tags:id,nombre');

        $proyecto = $callback->where('estudiante_id', $usuario->estudiante_id)->get();

        if ($proyecto) {
            return response()->json([
                'respuesta' => true,
                'mensaje' => $proyecto
            ], 200);
        } else {
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'El estudiante no tiene proyectos por el momento'
            ], 200);
        }

    }

    public function show($proyecto_id)
    {
        $proyecto = Proyecto::query()
            ->with('estudiante', 'estudiante.escuela', 'tags', 'portadas', 'proyectoArchivo')
            ->where('id', $proyecto_id)
            ->first();

        if (is_null($proyecto)) {
            return response()->json(['mensaje' => 'Proyecto No Econtrado'], 404);
        }
        return response()->json($proyecto, 200);
    }

    public function store(storeProyecto $request)
    {
        $proyecto = new Proyecto();
        $proyecto->uuid = Str::uuid();
        $proyecto->titulo = $request->titulo;
        $proyecto->resumen = $request->resumen;
        $proyecto->fecha_publicacion = $request->fecha_publicacion;
        $proyecto->estudiante_id = $request->estudiante_id;
        $proyecto->save();

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
            ->addSelect(['similitud' => ProyectoTag::select(DB::raw('count(*)'))
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

    public function valoracion($proyecto_id, $usuario_id)
    {
        $proyecto = Proyecto::query()
            ->select('id')
            ->addSelect(['por_usuario' => Valoracion::select('me_gusta')
                ->whereColumn('proyecto_id', 'proyectos.id')
                ->where('usuario_id', $usuario_id)
                ->take(1)
            ])
            ->withCount(['likes', 'dislikes'])->find($proyecto_id);
        if ($proyecto)
            return response()->json($proyecto, 200);

        return response()->json([], 204);
    }

    public function favorito($proyecto_id, $usuario_id)
    {
        $proyecto = Proyecto::query()
            ->select('id')
            ->whereHas('favorito', function ($query) use ($usuario_id) {
                $query->where('usuario_id', $usuario_id);
            })->find($proyecto_id);

        return response()->json(["es_favorito" => (bool)$proyecto], 200);
    }
}
