<?php

namespace Database\Factories;

use App\Models\Estudiante;
use App\Models\Proyecto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Favorito>
 */
class FavoritoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'fecha_agregacion' => $this->faker->dateTimeBetween('-4 months', 'now')->format("Y-m-d"),
            'estudiante_id' => Estudiante::inRandomOrder()->first()->id,
            'proyecto_id' => Proyecto::inRandomOrder()->first()->id
        ];
    }
}
