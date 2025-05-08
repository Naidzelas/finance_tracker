<?php

namespace Database\Factories\Budget;

use Illuminate\Database\Eloquent\Factories\Factory;

class BudgetTypesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'name' => $this->faker->word(),
            'amount' => $this->faker->numberBetween(100, 1000),
            'iconify_name' => $this->faker->word(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
