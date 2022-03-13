<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CicloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ciclos = [
            [
                'nombre' => 'I CICLO',
            ],
            [
                'nombre' => 'II CICLO',
            ],
            [
                'nombre' => 'III CICLO',
            ],
            [
                'nombre' => 'IV CICLO',
            ],
            [
                'nombre' => 'V CICLO',
            ],
            [
                'nombre' => 'VI CICLO',
            ],
            [
                'nombre' => 'VII CICLO',
            ],
            [
                'nombre' => 'VIII CICLO',
            ],
            [
                'nombre' => 'IX CICLO',
            ],
            [
                'nombre' => 'X CICLO',
            ],
        ];
        \App\Models\Ciclo::insert($ciclos);
    }
}
