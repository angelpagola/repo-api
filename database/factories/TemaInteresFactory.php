<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TemaInteres>
 */
class TemaInteresFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'tag_id' => Tag::inRandomOrder()->first()->id,
            'usuario_id' => Usuario::inRandomOrder()->first()->id,
        ];
    }
}
