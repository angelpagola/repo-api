<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MotivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $motivos = [
            [
                'nombre' => 'Contenido sexual',
            ],
            [
                'nombre' => 'Contenido violento o repulsivo',
            ],
            [
                'nombre' => 'Acoso o intimidación',
            ],
            [
                'nombre' => 'Actividades peligrosas o dañinas',
            ],
            [
                'nombre' => 'Maltrato infantil',
            ],
            [
                'nombre' => 'Fomenta el terrorismo',
            ],
            [
                'nombre' => 'Engañoso o con span',
            ],
            [
                'nombre' => 'Infringe mis derechos',
            ],
        ];
        \App\Models\Motivo::insert($motivos);
    }
}
