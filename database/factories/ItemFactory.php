<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => rand(1, 50),
            'cat_id' => rand(1, 50),
            'company_id' =>  rand(1, 50),
            'title'  => fake()->unique()->text(10),
            'notes' => fake()->unique()->text(50),
            'code' => fake()->unique()->numberBetween(1111111111, 9999999999),
            'price' => rand(52, 160),
            'sale_price' => rand(170, 300),
            'stock' => rand(1, 50),
        ];
    }
}
