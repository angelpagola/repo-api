<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $table = 'cursos';
    public $timestamps = false;
    public $fillable = ['nombres', 'escuela_id', 'ciclo_id'];

    public function escuela()
    {
        return $this->belongsTo(Escuela::class)
            ->with('facultad');
    }

    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class);
    }
}
