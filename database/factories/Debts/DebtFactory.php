<?php

namespace Database\Factories\Debts;

use App\Models\Debts\Debt;
use Illuminate\Database\Eloquent\Factories\Factory;


class DebtFactory extends Factory
{
    protected $model = Debt::class;
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
            'type_id' => 1,
            'active' => $this->faker->boolean(),
            'loan_size' => $this->faker->numberBetween(1000, 10000),
            'monthly_payment' => $this->faker->numberBetween(100, 1000),
            'loan_final_amount' => $this->faker->numberBetween(1000, 10000),
            'interest_rate' => $this->faker->randomFloat(2, 0, 10),
            'iconify_name' => $this->faker->word(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
