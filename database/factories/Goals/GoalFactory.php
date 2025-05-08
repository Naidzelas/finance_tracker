<?php

namespace Database\Factories\Goals;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Goals\Goal>
 */
class GoalFactory extends Factory
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
            'saving_account_iban' => $this->faker->iban(),
            'type_id' => 1,
            'end_goal' => $this->faker->numberBetween(1000, 10000),
            'contribution' => $this->faker->numberBetween(100, 1000),
            'iconify_name' => $this->faker->word(),
            'is_main_priority' => $this->faker->boolean(),
            'active' => $this->faker->boolean(),
        ];
    }
}
