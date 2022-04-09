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
            //Todo: FAT
            [
                'nombre' => 'Administración',
                'facultad_abrev' => 'FAT',
            ],
            [
                'nombre' => 'Turismo',
                'facultad_abrev' => 'FAT',
            ],
            //Todo: Facultad de Ciencias
            [
                'nombre' => 'Estadística e Informática',
                'facultad_abrev' => 'FC',
            ],
            [
                'nombre' => 'Ingeniería de Sistemas e Informática',
                'facultad_abrev' => 'FC',
            ],
            [
                'nombre' => 'Matemática',
                'facultad_abrev' => 'FC',
            ],
            //Todo: FCA
            [
                'nombre' => 'Agronomía',
                'facultad_abrev' => 'FCA',
            ],
            [
                'nombre' => 'Ingeniería Agrícola',
                'facultad_abrev' => 'FCA',
            ],
            //Todo: FCAM
            [
                'nombre' => 'Ingeniería Ambiental',
                'facultad_abrev' => 'FCAM',
            ],
            [
                'nombre' => 'Ingeniería Sanitaria',
                'facultad_abrev' => 'FCAM',
            ],
            //Todo: FCM
            [
                'nombre' => 'Enfermería',
                'facultad_abrev' => 'FCM',
            ],
            [
                'nombre' => 'Obstetricia',
                'facultad_abrev' => 'FCM',
            ],
            //Todo: Facultad de Ciencias Sociales, Educación Comunicación.
            [
                'nombre' => 'Arqueología',
                'facultad_abrev' => 'FCSEC',
            ],
            [
                'nombre' => 'Ciencias de la Comunicación',
                'facultad_abrev' => 'FCSEC',
            ],
            [
                'nombre' => 'Comunicación Lingüística y Literatura',
                'facultad_abrev' => 'FCSEC',
            ],
            [
                'nombre' => 'Primaria y Educación Bilingüe Intercultural',
                'facultad_abrev' => 'FCSEC',
            ],
            [
                'nombre' => 'Lengua Extranjera: Inglés',
                'facultad_abrev' => 'FCSEC',
            ],
            // Todo: FDCCPP
            [
                'nombre' => 'Derecho y Ciencias Políticas',
                'facultad_abrev' => 'FDCCPP',
            ],
            // Todo: FEC
            [
                'nombre' => 'Contabilidad',
                'facultad_abrev' => 'FEC',
            ],
            [
                'nombre' => 'Economia',
                'facultad_abrev' => 'FEC',
            ],
            // Todo: FIC
            [
                'nombre' => 'Arquitectura y Urbanismo',
                'facultad_abrev' => 'FIC',
            ],
            [
                'nombre' => 'Ingeniería Civil',
                'facultad_abrev' => 'FIC',
            ],
            // Todo: FIIA
            [
                'nombre' => 'Ingeniería de Industria Alimentarias',
                'facultad_abrev' => 'FIIA',
            ],
            [
                'nombre' => 'Ingeniería Industrial',
                'facultad_abrev' => 'FIIA',
            ],
            // Todo: FIMGM
            [
                'nombre' => 'Ingeniería de Minas',
                'facultad_abrev' => 'FIMGM',
            ],
        ];
        \App\Models\Escuela::insert($escuelas);
    }
}
