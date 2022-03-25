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
                'uuid' => '4996bb3a-0c4e-451b-9c55-95315e61c9a0',
                'usuario' => 'estudiante1',
                'password' => $password,
                'activo' => 1,
                'estudiante_id' => 1
            ],
            [
                'uuid' => '600c7f89-8226-4293-b52f-2184cfe1a3d3',
                'usuario' => 'estudiante2',
                'password' => $password,
                'activo' => 1,
                'estudiante_id' => 2
            ],
            [
                'uuid' => 'bfb2743e-d11b-4141-b0df-892c83f08caa',
                'usuario' => 'estudiante3',
                'password' => $password,
                'activo' => 1,
                'estudiante_id' => 3
            ],
            [
                'uuid' => '93d14d76-4bd3-4546-b25c-1f7dcab36e68',
                'usuario' => 'estudiante4',
                'password' => $password,
                'activo' => 1,
                'estudiante_id' => 4
            ],
            [
                'uuid' => '8d90b5d1-4d6a-4a5f-be8e-f36b2aa5e96c',
                'usuario' => 'estudiante5',
                'password' => $password,
                'activo' => 1,
                'estudiante_id' => 5
            ],
            [
                'uuid' => '9e17d160-a015-4058-b7b9-d90601a46663',
                'usuario' => 'estudiante6',
                'password' => $password,
                'activo' => 1,
                'estudiante_id' => 6
            ],
            [
                'uuid' => 'd912bad6-473c-46ae-b141-45b1bd2b6a39',
                'usuario' => 'estudiante7',
                'password' => $password,
                'activo' => 1,
                'estudiante_id' => 7
            ],
            [
                'uuid' => '9e43050d-2a95-4f3e-8bef-c7c785d017e8',
                'usuario' => 'estudiante8',
                'password' => $password,
                'activo' => 1,
                'estudiante_id' => 8
            ],
            [
                'uuid' => '33b0068e-75e2-4f48-8e05-db52a64b7199',
                'usuario' => 'estudiante9',
                'password' => $password,
                'activo' => 1,
                'estudiante_id' => 9
            ],
            [
                'uuid' => '4e4dcaa1-a226-4d58-bd34-7c7e32521f70',
                'usuario' => 'estudiante10',
                'password' => $password,
                'activo' => 1,
                'estudiante_id' => 10
            ],
        ];
        \App\Models\Usuario::insert($usuarios);
    }
}
