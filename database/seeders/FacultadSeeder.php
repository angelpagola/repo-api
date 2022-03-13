<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacultadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $facultades = [
            [
                'nombre' => 'Facultad de Ciencias',
                'abrev' => 'FC',
            ],
            [
                'nombre' => 'Facultad de Ciencias Sociales, Educación Comunicación.',
                'abrev' => 'FCSEC',
            ],
        ];
        \App\Models\Facultad::insert($facultades);
    }
}
