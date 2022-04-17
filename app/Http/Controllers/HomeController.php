<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\ProyectoTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request, $id)
    {
        $proyectos = Proyecto::query()
            ->select('id', 'uuid', 'titulo', 'estudiante_id')
            ->with('estudiante:id,apellidos,nombres,avatar', 'estudiante.usuario:usuario,estudiante_id', 'portada:id,link_imagen,proyecto_id');

        if ($id > 0) {
            $proyectos = $proyectos->addSelect(['similitud' => ProyectoTag::select(DB::raw('count(*)'))
                ->whereColumn('proyecto_id', 'proyectos.id')
                ->whereIn('tag_id', function ($query) use ($id) {
                    $query->select('tag_id')->from('tema_interes')->where('usuario_id', $id);
                })
                ->take(1)
            ])->having('similitud', '>', 0);
        }

        $proyectos = $proyectos->inRandomOrder()
            ->limit(14)
            ->get();

        if ($proyectos) {
//            if ($request->has('buscar')) {
//                $proyecto = $callback->where('titulo', 'like', '%' . $request->buscar . '%')
//                    ->orWhereHas('estudiante', function ($query) use ($request) {
//                        return $query
//                            ->where('nombres', 'like', '%' . $request->buscar . '%')
//                            ->orWhere('apellidos', 'like', '%' . $request->buscar . '%');
//                    })->get();
//            }
            return response()->json([
                'respuesta' => true,
                'mensaje' => $proyectos
            ], 200);

        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'No existe ningún proyectos para mostrar'
            ], 200);
        }
    }

    /*    Aún está en desarrollo ...*/
    public function buscar(Request $request)
    {
        //$request->buscar
        //$request->fecha_inicio
        //$request->fecha_fin
        //$request->escuelas[]

        $proyectos = Proyecto::query()
            ->select('id', 'uuid', 'titulo', 'estudiante_id')
            ->with('estudiante:id,apellidos,nombres,avatar', 'estudiante.usuario:usuario,estudiante_id', 'portada:id,link_imagen,proyecto_id');

        /*if ($request->has('fecha_desde') && $request->has('fecha_hasta')) {
            $proyectos = $proyectos->whereBetween('fecha_publicacion', [$request->fecha_desde, $request->fecha_hasta]);
            if ($request->has('buscar')) {
                $proyectos = $proyectos->where('titulo', 'like', '%' . $request->buscar . '%')
                    ->orWhere('resumen', 'like', '%' . $request->buscar . '%');
            }
        }*/

        /*if (count($request->escuelas)) {
            foreach ($request->escueslas as $escuela) {
                $proyectos = $proyectos->orWhereHas('estudiante', function ($query) use ($escuela) {
                    return $query
                        ->where('escuela_id', $escuela);
                });
            }
        }*/

        /* if ($usuario_id > 0) {
             $proyectos = $proyectos->addSelect(['similitud' => ProyectoTag::select(DB::raw('count(*)'))
                 ->whereColumn('proyecto_id', 'proyectos.id')
                 ->whereIn('tag_id', function ($query) use ($usuario_id) {
                     $query->select('tag_id')->from('tema_interes')->where('usuario_id', $usuario_id);
                 })
                 ->take(1)
             ])->having('similitud', '>', 0);
         }*/

        $proyectos = $proyectos->inRandomOrder()
            ->limit(14)
            ->get();

        if ($proyectos) {
            return response()->json([
                'respuesta' => true,
                'mensaje' => $proyectos
            ], 200);

        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'No existe ningún proyectos para mostrar'
            ], 200);
        }

    }
}
