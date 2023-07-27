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
            'user_id' => rand(1,50),
            'cat_id' => rand(1,50),
            'company_id' =>  rand(1,50),
            'title'  => fake()->unique()->text(10),
            'notes' => fake()->unique()->text(50),
            'code' => time(),
            'price' => rand(52,160),
            'price_of_sale' => rand(170,300),
            'qty' => rand(1,50),
        ];
    }
}
