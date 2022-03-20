<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorito extends Model
{
    use HasFactory;

    protected $table = 'favoritos';
    public $timestamps = false;
    public $fillable = ['fecha_agregacion', 'usuario_id', 'proyecto_id'];
}
