<?php

namespace Database\Factories;

use App\Models\Proyecto;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProyectoTag>
 */
class ProyectoTagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'proyecto_id' => Proyecto::inRandomOrder()->first()->id,
            'tag_id' => Tag::inRandomOrder()->first()->id
        ];
    }
}
