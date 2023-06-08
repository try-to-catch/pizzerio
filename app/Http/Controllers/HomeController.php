<?php

namespace App\Http\Controllers;

use App\Http\Resources\Category\CategoryEssentialsWithProductsResource;
use App\Models\Category;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(): Response
    {
        $categories = Category::query()
            ->limit(7)
            ->withWhereHas('products', function (Builder $query) {
                $query->where('is_for_sale', true);
            })
            ->with(['products' => function (Builder $query) {
                $query
                    ->where('is_for_sale', '1')
                    ->select(['id', 'title', 'thumbnail', 'category_id', 'price', 'slug', 'sale_price', 'priority', 'ingredients', 'banner'])
                    ->orderByDesc('priority');
            }])
            ->orderByDesc('updated_at')
            ->get(['id', 'title', 'icon', 'slug']);

        $categories->each(function ($category) {
            $category->products = $category->products->take(8);
        });

        return Inertia::render('Welcome', [
            'categories' => CategoryEssentialsWithProductsResource::collection($categories)->resolve(),
        ]);
    }
}
