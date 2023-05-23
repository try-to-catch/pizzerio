<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        Category::factory(10)->create(['user_id' => rand(1, 10)]);

        Product::factory(10)->create([
            'user_id' => rand(1, 10),
            'category_id' => rand(1, 10),
        ]);
    }
}
