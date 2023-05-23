<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->word(),
            'price' => fake()->numberBetween(10,100),
            'priority' => fake()->numberBetween(1,999),
            'thumbnail' => '',
            'ingredients' => fake()->words(8, true),
            'description' => fake()->paragraph(),
            'is_for_sale' => true,
        ];
    }
}
