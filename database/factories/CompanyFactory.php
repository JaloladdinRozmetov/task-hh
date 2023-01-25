<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'email' => $this->faker->companyEmail(),
            'coordinate_x' => $this->faker->randomNumber(1,100),
            'coordinate_y' => $this->faker->randomNumber(1,100),
        ];
    }
}
