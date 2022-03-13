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
                'nombre' => 'Matemática',
            ],
            [
                'nombre' => 'Ingeniería',
            ],
        ];
        \App\Models\Tag::insert($tags);
    }
}
