<?php

namespace Database\Factories;

use App\Models\Proyecto;
use App\Models\Usuario;
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
            'proyecto_id' => Proyecto::inRandomOrder()->first()->id,
            'usuario_id' => Usuario::inRandomOrder()->first()->id,
        ];
    }
}
