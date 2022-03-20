<?php

namespace Database\Factories;

use App\Models\Proyecto;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comentario>
 */
class ComentarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'mensaje' => $this->faker->sentence(1, 10),
            'usuario_id' => Usuario::inRandomOrder()->first()->id,
            'proyecto_id' => Proyecto::inRandomOrder()->first()->id
        ];
    }
}
