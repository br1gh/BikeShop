<?php

namespace Database\Factories;

use App\Models\Parameter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ParameterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $step = [1, 5, 10, 50];
        $max = [100, 500, 1000, 5000, 10000, 50000, 100000];

        $type = $this->faker->randomElement(array_keys(Parameter::getTypes()));
        $unit = null;

        if (Str::endsWith($type, 'with unit')) {
            $unit = $this->faker->word();
        }

        return [
            'type' => $type,
            'name' => $this->faker->words(2, true),
            'unit' => $unit,
            'for_bikes' => $this->faker->numberBetween(0, 1),
            'for_parts' => $this->faker->numberBetween(0, 1),
            'for_accessories' => $this->faker->numberBetween(0, 1),
            "step" => $this->faker->randomElement($step),
            'min' => 0,
            'max' => $this->faker->randomElement($max),
        ];
    }
}
