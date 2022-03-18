<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Todo: Nivel 0
        $this->call(TagSeeder::class);

        //Todo: Nivel 1
        $this->call(EscuelaSeeder::class);

        //Todo: Nivel 2
        \App\Models\Estudiante::factory(9)->create();
        \App\Models\Curso::factory(12)->create();

        //Todo: Nivel 3
        $this->call(UsuarioSeeder::class);
        \App\Models\Proyecto::factory(20)->create();

        //Todo: Nivel 4
        \App\Models\ProyectoTag::factory(20)->create();
        \App\Models\Favorito::factory(5)->create();

    }
}
