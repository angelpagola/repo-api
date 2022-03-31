<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $callback = Proyecto::query()
            ->select('id', 'uuid', 'titulo', 'estudiante_id')
            ->with('estudiante:id,apellidos,nombres,avatar', 'estudiante.usuario:usuario,estudiante_id', 'portada:id,link_imagen,proyecto_id');

        $proyecto = $callback->get()->random(14);

        if ($proyecto) {
            if ($request->has('buscar')) {
                $proyecto = $callback->where('titulo', 'like', '%' . $request->buscar . '%')
                    ->orWhereHas('estudiante', function ($query) use ($request) {
                        return $query
                            ->where('nombres', 'like', '%' . $request->buscar . '%')
                            ->orWhere('apellidos', 'like', '%' . $request->buscar . '%');
                    })->get();
            }
            return response()->json([
                'respuesta' => true,
                'mensaje' => $proyecto
            ], 200);

        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'No existe ningún proyectos para mostrar'
            ], 200);
        }
    }
}
