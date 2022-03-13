<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorito extends Model
{
    use HasFactory;

    protected $table = 'favoritos';
    public $timestamps = false;
    public $fillable = ['fecha_agregacion', 'estudiante_id', 'proyecto_id'];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class)
            ->with('escuela');
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class)
            ->with('curso','tag');
    }

}
