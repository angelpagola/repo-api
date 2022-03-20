<?php

namespace Database\Factories;

use App\Models\Proyecto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProyectoArchivoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'link_archivo' => 'documentos/' . $this->faker->image('public/storage/documentos', 640, 480, null, false),
            'proyecto_id' => Proyecto::inRandomOrder()->first()->id
        ];
    }
}
