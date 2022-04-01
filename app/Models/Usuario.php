<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';
    public $timestamps = false;
    protected $fillable = ['uuid', 'usuario', 'password', 'activo', 'estudiante_id'];

    protected $hidden = ['password'];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function valoracion()
    {
        return $this->belongsToMany(Proyecto::class, 'valoraciones');
    }

    public function favorito()
    {
        return $this->belongsToMany(Proyecto::class, 'favoritos');
    }

    public function tag()
    {
        return $this->belongsToMany(Tag::class, 'tema_interes')->withPivot('id');
    }

    public function comentario()
    {
        return $this->belongsToMany(Proyecto::class, 'comentarios');
    }

    public function reporte()
    {
        return $this->belongsToMany(Proyecto::class, 'reportes');
    }
}
