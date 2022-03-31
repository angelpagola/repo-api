<?php

namespace Database\Seeders;

use Database\Factories\EstudianteFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        \App\Models\Estudiante::factory(10)->create();

        //Todo: Nivel 2
        $this->call(UsuarioSeeder::class);
        \App\Models\Proyecto::factory(20)->create();

        //Todo: Nivel 3
        \App\Models\ProyectoTag::factory(50)->create();
        \App\Models\ProyectoImagen::factory(30)->create();
        \App\Models\ProyectoArchivo::factory(30)->create();
        \App\Models\Valoracion::factory(10)->create();
        \App\Models\Favorito::factory(10)->create();
        \App\Models\TemaInteres::factory(10)->create();
        \App\Models\Comentario::factory(5)->create();
        \App\Models\Reporte::factory(2)->create();

    }
}
