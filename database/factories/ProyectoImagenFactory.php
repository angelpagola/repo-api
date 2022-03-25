<?php

namespace Database\Factories;

use App\Models\Proyecto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProyectoImagen>
 */
class ProyectoImagenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'link_imagen' => 'imagenes/' . $this->faker->image('public/storage/imagenes', 640, 480, null, false),
            'proyecto_id' => Proyecto::inRandomOrder()->first()->id
        ];
    }
}
