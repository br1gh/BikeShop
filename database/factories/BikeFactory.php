<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => ucwords($this->faker->words(rand(2, 5), true)),
            'price' => $this->faker->randomFloat(2, 0, 25000)
        ];
    }
}
