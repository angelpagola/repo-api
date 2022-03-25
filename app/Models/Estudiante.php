<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $table = 'estudiantes';
    public $timestamps = false;
    public $fillable = ['uuid', 'nombres', 'apellidos', 'correo', 'telefono', 'linkedin', 'avatar', 'escuela_id'];

    public function escuela()
    {
        return $this->belongsTo(Escuela::class);
    }

    public function usuario()
    {
        return $this->hasOne(Usuario::class);
    }

    public function proyecto()
    {
        return $this->hasMany(Proyecto::class);
    }
}
