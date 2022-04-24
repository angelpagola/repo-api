<?php

namespace Database\Factories;

use App\Models\Escuela;
use App\Models\Estudiante;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $tieneCorreo = $this->faker->boolean(65);
        $tieneTelefono = $this->faker->boolean(75);
        $tieneLinkedin = $this->faker->boolean(40);
        $gender = $this->faker->randomElements(['male', 'female'])[0];

        $estudiante = Estudiante::create([
            'nombres' => $this->faker->firstName($gender) . ' ' . $this->faker->firstName($gender),
            'apellidos' => $this->faker->lastName . ' ' . $this->faker->lastName,
            'correo' => $tieneCorreo ? $this->faker->word . $this->faker->unique(true)->safeEmail() : null,
            'telefono' => $tieneTelefono ? $this->faker->unique(true)->numerify('9########') : null,
            'linkedin' => $tieneLinkedin ? $this->faker->url . rand(1, 100) : null,
            'escuela_id' => Escuela::inRandomOrder()->first()->id
        ]);

        $url = 'storage/avatars/';

        return [
            'uuid' => $this->faker->uuid(),
            'usuario' => str_replace(".", "", substr($this->faker->userName(), 0, rand(12, 20))) . rand(1, 2022),
            'password' => Hash::make('12345678'),
            'avatar' => asset($url . $this->faker->image('public/storage/avatars', 128, 128, null, false)),
            'activo' => true,
            'estudiante_id' => $estudiante->id
        ];
    }
}
