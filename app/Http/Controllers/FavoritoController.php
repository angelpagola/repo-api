<?php

namespace App\Http\Controllers;

use App\Models\Favorito;
use Illuminate\Http\Request;

class FavoritoController extends Controller
{

    public function index()
    {
        return Favorito::query()
            ->with('estudiante', 'proyecto')
            ->get();
    }

    public function show($id)
    {
        return Favorito::query()
            ->with('estudiante', 'proyecto')
            ->find($id);
    }
}
