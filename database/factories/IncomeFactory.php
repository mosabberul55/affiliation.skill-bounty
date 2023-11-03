<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Income>
 */
class IncomeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_phone' => rand(1000000000, 9999999999),
            'customer_name' => fake()->name(),
            'sale_price' => fake()->numberBetween(100000, 999999),
            'percent' => fake()->numberBetween(1, 100),
            'income' => fake()->numberBetween(10000, 99999),
            'code' => fake()->unique()->numberBetween(100000, 999999),
        ];
    }
}
