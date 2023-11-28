<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Perro;

class PerroFactory extends Factory
{
    protected $model = Perro::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->name,
            'foto_url' => $this->faker->imageUrl(),
            'descripcion' => $this->faker->text,
        ];
    }
}
