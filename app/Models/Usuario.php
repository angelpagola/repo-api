<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';
//    public $timestamps = false;
    protected $fillable = ['uuid', 'usuario', 'password', 'activo', 'avatar', 'estudiante_id'];

    protected $hidden = ['password'];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function proyectos()
    {
        return $this->hasMany(Proyecto::class)->orderBy('created_at', 'desc');
    }

    public function valoracion()
    {
        return $this->belongsToMany(Proyecto::class, 'valoraciones');
    }

    public function favoritos()
    {
        return $this->belongsToMany(Proyecto::class, 'favoritos')->withPivot('fecha_agregacion');
    }

    public function tag()
    {
        return $this->belongsToMany(Tag::class, 'tema_interes')->withPivot('id');
    }

    //Es similar a la function tag()
    public function intereses()
    {
        return $this->belongsToMany(Tag::class, 'tema_interes')->orderBy('nombre')->withPivot('id');
    }

    public function comentario()
    {
        return $this->belongsToMany(Proyecto::class, 'comentarios');
    }

    public function reporte()
    {
        return $this->belongsToMany(Proyecto::class, 'reportes')->withPivot('id');
    }
}
