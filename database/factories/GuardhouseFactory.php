<?php

namespace Database\Factories;

use App\Models\Guardhouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuardhouseFactory extends Factory
{
    protected $model = Guardhouse::class;

    public function definition(): array
    {
        return [
            //
            'name' => $this->faker->name(),
        ];
    }
}
