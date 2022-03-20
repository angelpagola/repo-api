<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    use HasFactory;

    protected $table = 'reportes';
    public $timestamps = false;
    public $fillable = ['motivo_id', 'usuario_id', 'proyecto_id'];

    public function motivo()
    {
        return $this->belongsTo(Motivo::class);
    }
}
