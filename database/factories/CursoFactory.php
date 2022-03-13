<?php

namespace Database\Factories;

use App\Models\Ciclo;
use App\Models\Escuela;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Curso>
 */
class CursoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombres' => $this->faker->sentence(15),
            'escuela_id' => Escuela::inRandomOrder()->first()->id,
            'ciclo_id' => Ciclo::inRandomOrder()->first()->id,
        ];
    }
}
