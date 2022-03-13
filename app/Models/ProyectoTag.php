<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyectoTag extends Model
{
    use HasFactory;

    protected $table = 'proyecto_tag';
    public $timestamps = false;
    public $fillable = ['proyecto_id', 'tag_id'];
}
