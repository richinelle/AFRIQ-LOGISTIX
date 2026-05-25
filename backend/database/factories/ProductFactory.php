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
        'name' => $this->faker->word(),
        'price' => $this->faker->numberBetween(100, 5000), // Prix entre 100 et 5000
        'stock' => $this->faker->numberBetween(0, 50),
        'category_id' => \App\Models\Category::factory(), // Crée une catégorie liée automatiquement
    ];
}
}
