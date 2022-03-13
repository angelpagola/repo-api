<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = Hash::make('12345678');

        $usuarios = [
            [
                'usuario' => 'estudiante1',
                'password' => $password,
                'estudiante_id' => 1
            ],
            [
                'usuario' => 'estudiante2',
                'password' => $password,
                'estudiante_id' => 2
            ],
            [
                'usuario' => 'estudiante3',
                'password' => $password,
                'estudiante_id' => 3
            ],
            [
                'usuario' => 'estudiante4',
                'password' => $password,
                'estudiante_id' => 4
            ],
            [
                'usuario' => 'estudiante5',
                'password' => $password,
                'estudiante_id' => 5
            ],
            [
                'usuario' => 'estudiante6',
                'password' => $password,
                'estudiante_id' => 6
            ],
            [
                'usuario' => 'estudiante7',
                'password' => $password,
                'estudiante_id' => 7
            ],
            [
                'usuario' => 'estudiante8',
                'password' => $password,
                'estudiante_id' => 8
            ],
            [
                'usuario' => 'estudiante9',
                'password' => $password,
                'estudiante_id' => 9
            ],
        ];
        \App\Models\Usuario::insert($usuarios);
    }
}
