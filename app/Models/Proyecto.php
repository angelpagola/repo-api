<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $table = 'proyectos';
    public $timestamps = false;
    public $fillable = ['titulo', 'resumen', 'fecha_publicacion', 'estudiante_id', 'curso_id'];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class)
            ->with('escuela');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class)
            ->with('escuela', 'ciclo');
    }

    public function tag()
    {
        return $this->belongsToMany(Tag::class);
    }
}
