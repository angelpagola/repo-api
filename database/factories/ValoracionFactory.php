<?php

namespace Database\Factories;

use App\Models\Proyecto;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Valoracion>
 */
class ValoracionFactory extends Factory
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
            'me_gusta' => true,
            'usuario_id' => Usuario::inRandomOrder()->first()->id,
            'proyecto_id' => Proyecto::inRandomOrder()->first()->id,
            'created_at' => $fecha,
            'updated_at' => $fecha,
        ];
    }
}
