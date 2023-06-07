<?php

namespace Database\Factories;

use App\Actions\Product\StoreThumbnailAction;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\File;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        $thumbnailPath = storage_path('app/public/images/defaults/nice-pizza.png');
        $thumbnail = new File($thumbnailPath);

        $storeThumbnailAction = new StoreThumbnailAction();
        $storagePath = $storeThumbnailAction->handle($thumbnail);

        return [
            'title' => fake()->unique()->word(),
            'price' => fake()->numberBetween(10, 100),
            'priority' => fake()->numberBetween(1, 999),
            'thumbnail' => $storagePath,
            'ingredients' => fake()->words(8, true),
            'description' => fake()->paragraph(),
            'is_for_sale' => true,
            'banner' => null,
        ];
    }
}
