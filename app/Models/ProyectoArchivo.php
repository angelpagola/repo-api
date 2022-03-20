<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyectoArchivo extends Model
{
    use HasFactory;

    protected $table = 'proyecto_archivos';
    public $timestamps = false;
    public $fillable = ['link_archivo', 'proyecto_id'];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
}
