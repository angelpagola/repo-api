<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Todo: General
        $ruta = 'public/proyectos/';
        Storage::deleteDirectory($ruta . 'imagenes');
        Storage::makeDirectory($ruta . 'imagenes');

        Storage::deleteDirectory($ruta . 'documentos');
        Storage::makeDirectory($ruta . 'documentos');

        Storage::deleteDirectory('public/avatars');
        Storage::makeDirectory('public/avatars');

        //Todo: Nivel 0
        $this->call(EscuelaSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(MotivoSeeder::class);

        //Todo: Nivel 1

        //Todo: Nivel 2
        \App\Models\Usuario::factory(450)->create();
        \App\Models\Proyecto::factory(2000)->create();

        //Todo: Nivel 3
        \App\Models\ProyectoTag::factory(7500)->create();
        \App\Models\ProyectoImagen::factory(2900)->create();
        \App\Models\ProyectoArchivo::factory(2900)->create();
        \App\Models\Valoracion::factory(10500)->create();
        \App\Models\Favorito::factory(9250)->create();
        \App\Models\TemaInteres::factory(4000)->create();
        \App\Models\Comentario::factory(1000)->create();
        \App\Models\Reporte::factory(900)->create();

    }
}
