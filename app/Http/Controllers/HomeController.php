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
            ])->where('estudiante_id', '<>', function ($query) use ($id) {
                $query->select('estudiante_id')->from('usuarios')->where('id', $id);
            })->having('similitud', '>', 0);
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

        if ($request->has('inicio') && $request->has('fin')) {
            $proyectos = $proyectos->whereBetween('fecha_publicacion', [$request->inicio, $request->fin]);
        }

        if ($request->has('buscar')) {
            $proyectos = $proyectos->where(function ($query) use ($request) {
                $query->where('titulo', 'like', '%' . $request->buscar . '%')/* ->orWhere('resumen', 'like', '%' . $request->buscar . '%')*/
                ;
            });
        }

        if ($request->has('escuelas') and count($request->escuelas)) {
            $proyectos = $proyectos->whereHas('estudiante', function ($query) use ($request) {
                return $query->whereIn('escuela_id', $request->escuelas);
            });
        }

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
