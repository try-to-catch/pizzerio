<?php

namespace App\Http\Controllers;

use App\Http\Resources\Category\CategoryEssentialsWithProductsResource;
use App\Http\Resources\Product\ProductDetailsResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $productSlug = $request->only('p');
        $parsedSlug = array_shift($productSlug);

        if ($parsedSlug) {
            $product = Product::query()->where('slug', $parsedSlug)->first([
                "id", "slug", "title", "ingredients", "description", "price", "sale_price", "banner", "thumbnail",
            ]);
            $resolvedProduct = ProductDetailsResource::make($product)->resolve();
        }

        if (Cache::has('home_page_categories')) {
            $categories = Cache::get('home_page_categories');
        } else {
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

            Cache::put('home_page_categories', $categories, now()->addMinutes(10));
        }

        return Inertia::render('Welcome', [
            'categories' => CategoryEssentialsWithProductsResource::collection($categories)->resolve(),
            'selectedProduct' => $resolvedProduct ?? []
        ]);
    }
}
