<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyectoImagen extends Model
{
    use HasFactory;

    protected $table = 'proyecto_imagenes';
    public $timestamps = false;
    public $fillable = ['link_imagen', 'proyecto_id'];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }

}
