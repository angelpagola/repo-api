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
        Storage::deleteDirectory('public/imagenes');
        Storage::makeDirectory('public/imagenes');

        Storage::deleteDirectory('public/documentos');
        Storage::makeDirectory('public/documentos');

        //Todo: Nivel 0
        $this->call(EscuelaSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(MotivoSeeder::class);

        //Todo: Nivel 1
        \App\Models\Estudiante::factory(5)->create();

        //Todo: Nivel 2
        $this->call(UsuarioSeeder::class);
        \App\Models\Proyecto::factory(5)->create();

        //Todo: Nivel 3
        \App\Models\ProyectoTag::factory(10)->create();
        \App\Models\ProyectoImagen::factory(10)->create();
        \App\Models\ProyectoArchivo::factory(10)->create();
        \App\Models\Valoracion::factory(3)->create();
        \App\Models\Favorito::factory(3)->create();
        \App\Models\TemaInteres::factory(5)->create();
        \App\Models\Comentario::factory(2)->create();
        \App\Models\Reporte::factory(1)->create();

    }
}
