<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemaInteres extends Model
{
    use HasFactory;

    protected $table = 'tema_interes';
    public $timestamps = false;
    public $fillable = ['tag_id', 'usuario_id'];
}
