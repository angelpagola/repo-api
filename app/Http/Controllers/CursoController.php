<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {
        return Curso::query()
            ->with('escuela', 'ciclo')
            ->get();
    }

    public function show($id)
    {
        return Curso::query()
            ->with('escuela', 'ciclo')
            ->find($id);
    }
}
