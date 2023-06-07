<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = Category::query()->inRandomOrder()->first('id');
        $user = User::query()->inRandomOrder()->first('id');

        Product::factory(5)->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);
    }
}
