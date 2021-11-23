<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->lastName(),
            'price' => $this->faker->numberBetween(100, 300),
            'quantity' => $this->faker->numberBetween(1, 10),
            'is_available' => $this->faker->boolean(),
            'description' => $this->faker->sentence()
        ];
    }
}
