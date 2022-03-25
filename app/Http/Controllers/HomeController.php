<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('buscar')) {
            if (is_null($request->buscar)) {
                $proyecto = Proyecto::query()
                    ->with('estudiante', 'proyectoImagen')
                    ->get()->random(10);
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
                ->select('id', 'uuid', 'titulo', 'estudiante_id')
                ->with('estudiante:id,apellidos,nombres,avatar', 'estudiante.usuario:usuario,estudiante_id', 'proyectoImagen:id,link_imagen,proyecto_id')
                ->whereHas('proyectoImagen', function ($query) {
                    $query->orderBy('id', 'desc');
                })
                ->get()->random(10);

            /*$proyecto = DB::table('proyectos')
                ->join('estudiantes', 'estudiantes.id', '=', 'proyectos.estudiante_id')
                ->join('usuarios', 'usuarios.estudiante_id', '=', 'estudiantes.id')
                ->join('proyecto_imagenes', 'proyectos.id', '=', 'proyecto_imagenes.proyecto_id')
                ->select('proyectos.id', 'proyectos.uuid', 'proyectos.titulo', 'proyecto_imagenes.link_imagen', 'estudiantes.apellidos', 'estudiantes.nombres', 'estudiantes.avatar', 'usuarios.usuario')
                ->get()->random(10);*/
        }

        return response()->json($proyecto, 200);
    }
}
