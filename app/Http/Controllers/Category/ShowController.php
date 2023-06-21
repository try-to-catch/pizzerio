<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryEssentialsResource;
use App\Http\Resources\Product\ProductDetailsResource;
use App\Http\Resources\Product\ProductEssentialsResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ShowController extends Controller
{
    public function __invoke(Request $request, Category $category): Response
    {
        $productSlug = $request->only('p');
        $parsedSlug = array_shift($productSlug);

        if ($parsedSlug) {
            $product = $category->products()->where('slug', $parsedSlug)->first([
                "id", "slug", "title", "ingredients", "description", "price", "sale_price", "banner", "thumbnail",
            ]);
            $resolvedProduct = ProductDetailsResource::make($product)->resolve();
        }

        $products = $category->products()
            ->where('is_for_sale', '1')
            ->select(['id', 'title', 'thumbnail', 'category_id', 'price', 'slug', 'sale_price', 'priority', 'ingredients', 'banner'])
            ->orderByDesc('priority')
            ->paginate(12);

        $categoryResource = CategoryEssentialsResource::make($category)->resolve();
        $categoryResource['products'] = $products->toArray();
        $categoryResource['products']['data'] = ProductEssentialsResource::collection($products)->resolve();

        $linksCount = count($categoryResource['products']['links']);
        $categoryResource['products']['links'][0]['label'] = '&laquo;';
        $categoryResource['products']['links'][$linksCount - 1]['label'] = '&raquo;';

        return Inertia::render('Category/Show', [
            'category' => $categoryResource,
            'selectedProduct' => $resolvedProduct ?? []
        ]);

    }
}
