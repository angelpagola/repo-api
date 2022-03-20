<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'tags';
    public $timestamps = false;
    public $fillable = ['nombre'];

    public function proyecto()
    {
        return $this->belongsToMany(Proyecto::class, 'proyecto_tags');
    }

    public function usuario()
    {
        return $this->belongsToMany(Usuario::class, 'tema_interes');
    }
}
