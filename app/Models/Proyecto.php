<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $table = 'proyectos';
//    public $timestamps = false;
    public $fillable = ['uuid', 'titulo', 'resumen', 'usuario_id'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function tags()
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

    public function archivos()
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

    public function favoritos()
    {
        return $this->belongsToMany(Usuario::class, 'favoritos')->withPivot('fecha_agregacion');
    }

    public function comentario()
    {
        return $this->belongsToMany(Usuario::class, 'comentarios');
    }

    public function reporte()
    {
        return $this->belongsToMany(Usuario::class, 'reportes');
    }

    // Es similar a reporte
    public function reportes()
    {
        return $this->hasMany(Reporte::class);
    }
}
