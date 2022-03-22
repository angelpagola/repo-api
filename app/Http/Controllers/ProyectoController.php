<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProyectoController extends Controller
{
    public function index()
    {
        $proyecto = Proyecto::query()
            ->with('estudiante', 'tag', 'proyectoImagen', 'proyectoArchivo')
            ->get();
        return response()->json($proyecto, 200);
    }

    public function show($id)
    {
        $proyecto = Proyecto::query()
            ->with('estudiante', 'tag', 'proyectoImagen', 'proyectoArchivo')
            ->find($id);
        if (is_null($proyecto)) {
            return response()->json(['message' => 'Project Not Found'], 404);
        }
        return response()->json($proyecto, 200);
    }

    public function store(Request $request)
    {
        /*$request->validate([
            'titulo' => 'requerid|max:200',
            'resumen' => 'requerid|max:1000',
            'fecha_publicacion' => 'requerid|date',
            'estudiante_id' => 'required|integer|gt:0',
        ]);

        Proyecto::create([
            'uuid' => Str::uuid(),
            'titulo' => $request->titulo,
            'resumen' => $request->resumen,
            'fecha_publicacion' => $request->fecha_publicacion,
            'estudiante_id' => $request->estudiante_id,
        ]);*/

        $proyecto = new Proyecto();
        $proyecto->uuid = Str::uuid();
        $proyecto->titulo = $request->titulo;
        $proyecto->resumen = $request->resumen;
        $proyecto->fecha_publicacion = $request->fecha_publicacion;
        $proyecto->estudiante_id = $request->estudiante_id;

        $proyecto->save();

        return response()->json($proyecto, 201);
    }

    public function update(Request $request, $id)
    {
        $proyecto = Proyecto::findOrFail($id)
            ->update($request->all());
        if (is_null($proyecto)) {
            return response()->json(['message' => 'Project Not Found'], 404);
        }
        return response()->json($proyecto, 200);
    }

    public function destroy($id)
    {
        $proyecto = Proyecto::destroy($id);
        if (is_null($proyecto)) {
            return response()->json(['message' => 'Project Not Found'], 404);
        }
        return response()->json(null, 204);
    }
}
