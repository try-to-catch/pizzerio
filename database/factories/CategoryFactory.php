<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fileContent = file_get_contents(public_path('images/categories/snacks.svg'));

        $randomFileName = Str::random(10) . '.svg';
        Storage::disk('public')->put('images/categories/' . $randomFileName, $fileContent);

        return [
            'title' => fake()->unique()->word(),
            'icon' => 'images/categories/'. $randomFileName,
        ];
    }
}
