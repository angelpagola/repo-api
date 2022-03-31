<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            [
                'nombre' => 'Tecnología Web',
            ],
            [
                'nombre' => 'Telecomunicaciones',
            ],
            [
                'nombre' => 'Gestión ambiental',
            ],
            [
                'nombre' => 'Gerencia de Proyectos',
            ],
            [
                'nombre' => 'Innovación y Emprendimiento',
            ],
            [
                'nombre' => 'Seguridad Informática.',
            ],
            [
                'nombre' => 'Sistemas de Información',
            ],
            [
                'nombre' => 'Construcción y Gestión',
            ],
            [
                'nombre' => 'Estructuras',
            ],
            [
                'nombre' => 'Diagnóstico Empresarial',
            ],
        ];
        \App\Models\Tag::insert($tags);
    }
}
