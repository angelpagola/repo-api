<?php

namespace Database\Factories;

use App\Models\Escuela;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estudiante>
 */
class EstudianteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $url = '/repo-api/storage/app/public/avatars/';
        return [
            'uuid' => $this->faker->uuid,
            'nombres' => $this->faker->firstName . ' ' . $this->faker->firstName,
            'apellidos' => $this->faker->lastName . ' ' . $this->faker->lastName,
            'correo' => $this->faker->unique(true)->safeEmail(),
            'telefono' => $this->faker->unique(true)->numerify('#########'),
            'linkedin' => $this->faker->url,
            'avatar' => asset($url . $this->faker->image('public/storage/avatars', 640, 480, null, false)),
            'escuela_id' => Escuela::inRandomOrder()->first()->id
        ];
    }
}
