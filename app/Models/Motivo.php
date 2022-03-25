<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motivo extends Model
{
    use HasFactory;

    protected $table = 'motivos';
    public $timestamps = false;
    public $fillable = ['nombre'];

    public function reporte()
    {
        return $this->belongsToMany(Reporte::class);
    }
}
