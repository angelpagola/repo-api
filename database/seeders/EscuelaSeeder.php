<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EscuelaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $escuelas = [
            //Todo: Facultad de Ciencias
            [
                'nombre' => 'Matemática',
                'abrev' => 'MT',
                'facultad_id' => 1,
            ],
            [
                'nombre' => 'Estadística e Informática',
                'abrev' => 'EI',
                'facultad_id' => 1,
            ],
            [
                'nombre' => 'Ingeniería de Sistemas e Informática',
                'abrev' => 'ISI',
                'facultad_id' => 1,
            ],
            //Todo: Facultad de Ciencias Sociales, Educación Comunicación.
            [
                'nombre' => 'Comunicación Lingüística y Literatura',
                'abrev' => 'CLL',
                'facultad_id' => 2,
            ],
            [
                'nombre' => 'Lengua Extranjera: Inglés',
                'abrev' => 'CE',
                'facultad_id' => 2,
            ],
            [
                'nombre' => 'Primaria y Educación Bilingüe Intercultural',
                'abrev' => 'PEBI',
                'facultad_id' => 2,
            ],
            [
                'nombre' => 'Matemática e Informática',
                'abrev' => 'MI',
                'facultad_id' => 2,
            ],
            [
                'nombre' => 'Ciencias de la Comunicación',
                'abrev' => 'CC',
                'facultad_id' => 2,
            ],
            [
                'nombre' => 'Arqueología',
                'abrev' => 'AQ',
                'facultad_id' => 2,
            ],
        ];
        \App\Models\Escuela::insert($escuelas);
    }
}
