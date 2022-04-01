<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeProyecto;
use App\Http\Requests\updateProyecto;
use App\Models\Proyecto;
use App\Models\ProyectoTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProyectoController extends Controller
{
    public function indexG()
    {
        $proyecto = Proyecto::query()
            ->with('estudiante', 'tag', 'proyectoImagen')
            ->get()->random(2);
        return response()->json($proyecto, 200);
    }

    public function index(Request $request)
    {
        if ($request->has('buscar')) {
            if (is_null($request->buscar)) {
                $proyecto = Proyecto::query()
                    ->with('estudiante', 'tag', 'proyectoImagen')
                    ->get()->random(2);
            } else {
                $proyecto = Proyecto::query()
                    ->with('estudiante', 'tag', 'proyectoImagen')
                    ->where('titulo', 'like', '%' . $request->buscar . '%')
                    ->orWhereHas('estudiante', function ($query) use ($request) {
                        return $query->where('nombres', 'like', '%' . $request->buscar . '%');
                    })
                    ->orWhereHas('tag', function ($query) use ($request) {
                        return $query->where('nombre', 'like', '%' . $request->buscar . '%');
                    })
                    ->get();
            }
        } else {
            $proyecto = Proyecto::query()
                ->with('estudiante', 'tag', 'proyectoImagen')
                ->get()->random(2);
        }

        return response()->json($proyecto, 200);
    }

    public function show($id)
    {
        $proyecto = Proyecto::query()
            ->with('estudiante', 'estudiante.escuela', 'tag', 'portadas', 'proyectoArchivo')
            ->where('id', $id)
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

    public function recomendados($id)
    {
        $proyectos = Proyecto::query()
            ->select('id', 'titulo', 'estudiante_id')
            ->addSelect(['similitud' => ProyectoTag::select(DB::raw('count(*)'))
                ->whereColumn('proyecto_id', 'proyectos.id')
                ->whereIn('tag_id', function ($query) use ($id) {
                    $query->select('tag_id')->from('proyecto_tags')->where('proyecto_id', $id);
                })
                ->take(1)
            ])
            ->with('portada', 'estudiante:id', 'estudiante.usuario:usuario,estudiante_id')
            ->having('id', '<>', $id)
            ->orderBy('similitud', 'desc')
            ->orderBy('fecha_publicacion', 'desc')
            ->limit(3)
            ->get();

        return response()->json($proyectos, 200);

    }
}
