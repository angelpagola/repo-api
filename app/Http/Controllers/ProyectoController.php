<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    public function index()
    {
        return Proyecto::query()
            ->with('estudiante', 'curso','tag')
            ->get();
    }

    public function show($id)
    {
        return Proyecto::query()
            ->with('estudiante', 'curso','tag')
            ->find($id);
    }
}
