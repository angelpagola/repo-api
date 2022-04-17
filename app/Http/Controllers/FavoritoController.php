<?php

namespace App\Http\Controllers;

use App\Models\Favorito;
use App\Models\Proyecto;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FavoritoController extends Controller
{

    public function index(Request $request, $usuario)
    {
        $usuario = Usuario::query()->where('usuario', $usuario)->first();
        $search = $request->get('buscar') ?? "";

        if (!$usuario)
            return response()->json(["respuesta" => false, "mensaje" => 'El usuario no existe'], 200);

        $favoritos = Proyecto::query()
            ->select('id', 'uuid', 'titulo', 'estudiante_id')
            ->addSelect(['agregado_el' => Favorito::select('fecha_agregacion')
                ->whereColumn('proyecto_id', 'proyectos.id')
                ->where('usuario_id', $usuario->id)
                ->take(1)
            ])
            ->with('estudiante:id,apellidos,nombres,avatar', 'estudiante.usuario:usuario,estudiante_id', 'portada:id,link_imagen,proyecto_id')
            ->whereHas('favoritos', function ($query) use ($usuario) {
                $query->where('usuario_id', $usuario->id);
            })
            ->where('titulo', 'like', '%' . $search . '%')
            ->orderBy('agregado_el', 'desc')
            ->get();

        return response()->json(["respuesta" => true, "mensaje" => $favoritos], 200);
    }

    public function store($proyecto_id, $usuario_id)
    {
        $proyecto = Proyecto::query()->find($proyecto_id);
        $usuario = Usuario::query()->find($usuario_id);

        if (!$proyecto)
            return response()->json(["respuesta" => false, "mensaje" => 'El proyecto no existe'], 200);

        if (!$usuario)
            return response()->json(["respuesta" => false, "mensaje" => 'El usuario no existe'], 200);

        Favorito::create([
            'fecha_agregacion' => Carbon::now(),
            'usuario_id' => $usuario_id,
            'proyecto_id' => $proyecto_id,
        ]);

        return response()->json([
            'respuesta' => true,
            'mensaje' => Proyecto::query()->where('id', $proyecto_id)->first()
        ], 201);
    }

    public function destroy($proyecto_id, $usuario_id)
    {
        $proyecto = Proyecto::query()->find($proyecto_id);
        $usuario = Usuario::query()->find($usuario_id);

        if (!$proyecto)
            return response()->json(["respuesta" => false, "mensaje" => 'El proyecto no existe'], 200);

        if (!$usuario)
            return response()->json(["respuesta" => false, "mensaje" => 'El usuario no existe'], 200);

        $favorito = Favorito::query()
            ->where('proyecto_id', $proyecto_id)
            ->where('usuario_id', $usuario_id)
            ->first();

        if ($favorito) {
            $favorito->delete();
            return response()->json([
                'respuesta' => true,
                'mensaje' => Proyecto::query()->where('id', $proyecto_id)->first()
            ], 201);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'El proyecto en favoritos ya está eliminado'
            ], 200);
        }
    }
}
