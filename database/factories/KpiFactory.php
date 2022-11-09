<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KpiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->email,
            'year' => $this->faker->randomNumber,
            'month' => $this->faker->randomNumber,
            'value' => $this->faker->randomNumber,
            'type' => $this->faker->text,
            'subtype' => $this->faker->text,
        ];
    }
}
