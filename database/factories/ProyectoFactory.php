<?php

namespace Database\Factories;

use App\Models\Usuario;
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
        $fecha = $this->faker->dateTimeBetween('-18 months', 'now');

        return [
            'uuid' => $this->faker->uuid,
            'titulo' => $this->faker->sentence(15),
            'resumen' => $this->faker->paragraph() . " " . $this->faker->paragraph(),
            'usuario_id' => Usuario::inRandomOrder()->first()->id,
            'created_at' => $fecha,
            'updated_at' => $fecha,
        ];
    }
}
