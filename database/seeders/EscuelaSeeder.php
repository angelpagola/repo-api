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
                'uuid' => '3ad14572-5c34-412f-9c03-f4cc46d341fc',
                'nombre' => 'Matemática',
                'facultad_abrev' => 'FC',
            ],
            [
                'uuid' => '57b078a5-2980-453a-8aec-e04629faa079',
                'nombre' => 'Estadística e Informática',
                'facultad_abrev' => 'FC',
            ],
            [
                'uuid' => 'a5165d5f-23bf-4e13-bcbb-61d307d97d8f',
                'nombre' => 'Ingeniería de Sistemas e Informática',
                'facultad_abrev' => 'FC',
            ],
            //Todo: Facultad de Ciencias Sociales, Educación Comunicación.
            [
                'uuid' => '2d58efc1-518e-43f3-95f3-373b287e6adf',
                'nombre' => 'Comunicación Lingüística y Literatura',
                'facultad_abrev' => 'FCSEC',
            ],
            [
                'uuid' => 'dae0c234-5556-4128-a3b7-5cf49f5bc53b',
                'nombre' => 'Lengua Extranjera: Inglés',
                'facultad_abrev' => 'FCSEC',
            ],
            [
                'uuid' => 'e1a0e4b1-9227-46e1-b3ff-5226b787c755',
                'nombre' => 'Primaria y Educación Bilingüe Intercultural',
                'facultad_abrev' => 'FCSEC',
            ],
            [
                'uuid' => 'e60829be-13cf-4648-b925-651e5dd7db89',
                'nombre' => 'Matemática e Informática',
                'facultad_abrev' => 'FCSEC',
            ],
            [
                'uuid' => '79cf06b0-c176-4db7-8a5b-b671d9e0b7f8',
                'nombre' => 'Ciencias de la Comunicación',
                'facultad_abrev' => 'FCSEC',
            ],
            [
                'uuid' => '38065ed3-0f2b-40ed-b84d-e3a4a1497cc7',
                'nombre' => 'Arqueología',
                'facultad_abrev' => 'FCSEC',
            ],
        ];
        \App\Models\Escuela::insert($escuelas);
    }
}
