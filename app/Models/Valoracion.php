<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    use HasFactory;

    protected $table = 'valoraciones';
    public $timestamps = false;
    public $fillable = ['me_gusta', 'usuario_id', 'proyecto_id'];

}
