<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $table = 'proyectos';
    public $timestamps = false;
    public $fillable = ['uuid', 'titulo', 'resumen', 'fecha_publicacion', 'estudiante_id'];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function tag()
    {
        return $this->belongsToMany(Tag::class, 'proyecto_tags');
    }

    public function portadas()
    {
        return $this->hasMany(ProyectoImagen::class);
    }

    public function portada()
    {
        return $this->hasOne(ProyectoImagen::class);
    }

    public function proyectoArchivo()
    {
        return $this->hasMany(ProyectoArchivo::class);
    }

    public function valoracion()
    {
        return $this->belongsToMany(Usuario::class, 'valoraciones');
    }

    public function likes()
    {
        return $this->belongsToMany(Usuario::class, 'valoraciones')->withPivot('me_gusta')->where('me_gusta', true);
    }

    public function dislikes()
    {
        return $this->belongsToMany(Usuario::class, 'valoraciones')->withPivot('me_gusta')->where('me_gusta', false);
    }

    public function favorito()
    {
        return $this->belongsToMany(Usuario::class, 'favoritos');
    }

    public function comentario()
    {
        return $this->belongsToMany(Usuario::class, 'comentarios');
    }

    public function reporte()
    {
        return $this->belongsToMany(Usuario::class, 'reportes');
    }
}
