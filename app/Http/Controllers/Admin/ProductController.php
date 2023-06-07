<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Product\StoreThumbnailAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Http\Resources\Category\CategoryMinResource;
use App\Http\Resources\Product\ProductEditResource;
use App\Http\Resources\Product\ProductIndexResource;
use App\Http\Resources\Product\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(Request $request): Response
    {

        $searchQuery = $request->only('s');
        $parsedSearch = array_shift($searchQuery);

        if (gettype($parsedSearch) !== 'string' && gettype($parsedSearch) !== 'NULL') {
            abort(400);
        }

        $products = Product::query()
            ->select('products.id', 'products.slug', 'products.title', 'products.price', 'products.is_for_sale', 'products.thumbnail', 'products.updated_at', 'users.email as user_email', 'categories.title as category_title', 'categories.slug as category_slug')
            ->join('users', 'users.id', '=', 'products.user_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->when($parsedSearch, function (Builder $query) use ($parsedSearch) {
                $query->where('products.title', 'like', '%' . $parsedSearch . '%');
            })
            ->orderByDesc('products.updated_at')
            ->paginate(6);

        $dataForResponse['products'] = $products->toArray();
        $dataForResponse['products']['data'] = ProductIndexResource::collection($products)->resolve();

        return Inertia::render('Admin/Products/Index', $dataForResponse);
    }

    public function create(): Response
    {
        $categories = Category::all(['id', 'title']);

        return Inertia::render('Admin/Products/Create', [
            'categories' => CategoryMinResource::collection($categories)->resolve()
        ]);
    }


    public function store(StoreProductRequest $request, StoreThumbnailAction $storeThumbnailAction): RedirectResponse
    {
        $data = $request->validated();
        $thumbnail = $request->file('thumbnail');

        $data['title'] = ucfirst($data['title']);
        $data['thumbnail'] = $storeThumbnailAction->handle($thumbnail);;

        $product = $request->user()->products()->create($data);

        return redirect()->route('admin.products.show', ['product' => $product->slug]);
    }


    public function show(Product $product): Response
    {
        $product->load([
            'user' => function ($query) {
                $query->select('id', 'email');
            },
            'category' => function ($query) {
                $query->select('id', 'slug', 'title');
            }
        ]);

        return Inertia::render('Admin/Products/Show', [
            'product' => ProductResource::make($product)->resolve(),
            'number_of_related_orders' => 0
        ]);
    }


    public function edit(Product $product): Response
    {
        $categories = Category::all(['id', 'title']);

        return Inertia::render('Admin/Products/Edit',
            [
                'product' => ProductEditResource::make($product)->resolve(),
                'categories' => CategoryMinResource::collection($categories)->resolve()
            ]);
    }


    public function update(UpdateProductRequest $request, Product $product, StoreThumbnailAction $storeThumbnailAction):
    \Illuminate\Contracts\Foundation\Application|ResponseFactory|Application|\Illuminate\Http\Response|RedirectResponse
    {
        $data = $request->validated();
        $thumbnail = $request->file('thumbnail');
        unset($data['thumbnail']);

        if (isset($thumbnail)) {
            Storage::disk('public')->delete($product->thumbnail);

            $data['thumbnail'] = $storeThumbnailAction->handle($thumbnail);
        }

        if (array_key_exists('title', $data)) {
            $data['title'] = ucfirst($data['title']);

            if ($data['title'] === $product->title) {
                unset($data['title']);
            }
        }

        try {
            $product->updateOrFail($data);
        } catch (QueryException) {
            return redirect()->back()->withErrors(['title' => 'The title has already been taken.']);
        }

        return redirect()->route('admin.products.show', ['product' => $product->slug]);
    }


    public function destroy(Product $product):
    \Illuminate\Contracts\Foundation\Application|ResponseFactory|Application|\Illuminate\Http\Response|RedirectResponse
    {
        Storage::disk('public')->delete($product->thumbnail);
        if ($product->delete()) {
            return redirect()->route('admin.products.index')->with(['message' => 'The product has been deleted successfully']);
        }

        return redirect()->back()
            ->withErrors(['message' => 'Something went wrong. Try again later or contact tech support']);
    }
}
