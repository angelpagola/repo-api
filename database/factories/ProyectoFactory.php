<?php

namespace Database\Factories;

use App\Models\Curso;
use App\Models\Estudiante;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proyecto>
 */
class ProyectoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid,
            'titulo' => $this->faker->sentence(10),
            'resumen' => $this->faker->paragraph() . " " . $this->faker->paragraph(),
            'fecha_publicacion' => $this->faker->dateTimeBetween('-6 months', 'now')->format("Y-m-d"),
            'estudiante_id' => Estudiante::inRandomOrder()->first()->id,
        ];
    }
}
