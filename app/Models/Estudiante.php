<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $table = 'estudiantes';
    public $timestamps = false;
    public $fillable = ['nombres', 'apellidos', 'correo', 'telefono', 'foto', 'escuela_id'];

    public function escuela()
    {
        return $this->belongsTo(Escuela::class)
            ->with('facultad');
    }
}
