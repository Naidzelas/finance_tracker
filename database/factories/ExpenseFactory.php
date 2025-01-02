<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type_id' => rand(1,100),
            'amount' => rand(1,100),
            'date' => fake()->date('Y-m-d')
        ];
    }
}
