<?php

namespace App\Http\Controllers;

use App\Models\Favorito;
use App\Models\Usuario;
use Illuminate\Http\Request;

class FavoritoController extends Controller
{

    public function index()
    {
        $favorito = Usuario::query()
            ->with('estudiante', 'favorito', 'favorito.estudiante', 'favorito.proyectoImagen')
            ->where('id', 2)
            ->get();
        return response()->json($favorito, 200);
    }

    public function show($id)
    {
        $favorito = Usuario::query()
            ->with('estudiante', 'favorito', 'favorito.estudiante', 'favorito.proyectoImagen', 'favorito.proyectoArchivo')
            ->where('favorito', )
            ->find($id);
        return response()->json($favorito, 200);
    }
}
