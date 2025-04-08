<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Investment\Investment>
 */
class InvestmentFactory extends Factory
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
            'symbol' => $this->faker->word(),
            'instrument_id' => 1,
            'investment_type_id' => 1,
            'iconify_name' => $this->faker->word(),
            'investment_sector_id' => 1,
            'invested' => $this->faker->numberBetween(100, 1000),
            'profit' => $this->faker->numberBetween(0, 100),
            'profit_percent' => $this->faker->randomFloat(2, 0, 100),
            'is_green' => $this->faker->boolean(),
            'value' => $this->faker->numberBetween(100, 1000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
