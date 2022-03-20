<?php

namespace Database\Factories;

use App\Models\Motivo;
use App\Models\Proyecto;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reporte>
 */
class ReporteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'motivo_id' => Motivo::inRandomOrder()->first()->id,
            'usuario_id' => Usuario::inRandomOrder()->first()->id,
            'proyecto_id' => Proyecto::inRandomOrder()->first()->id
        ];
    }
}
