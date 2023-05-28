<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\Category\CategoryMinResource;
use App\Http\Resources\Product\ProductIndexResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function index(Request $request): Response
    {

        $searchQuery = $request->only('s');
        $parsedSearch = array_shift($searchQuery);

        if (gettype($parsedSearch) !== 'string') {
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

        $message = session('message');
        if ($message) {
            $dataForResponse['message'] = $message;
        }

        return Inertia::render('Admin/Products/Index', $dataForResponse);
    }

    public function create(): Response
    {
        $categories = Category::all(['id', 'title', 'thumbnail']);
        $preparedCategories = CategoryMinResource::collection($categories)->resolve();

        return Inertia::render('Admin/Products/Create', ['categories' => $preparedCategories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $thumbnail = $request->file('thumbnail');

        $fileName = $thumbnail->hashName();
        $filePath = "images/products/";
        $fullFilePath = "storage/" . $filePath;

        if (!file_exists($fullFilePath)) {
            mkdir($fullFilePath, 666, true);
        }

        $resizedThumbnail = Image::make($thumbnail)
            ->fit(450, 450)
            ->save($fullFilePath . $fileName);


        if (!$resizedThumbnail) {
            abort(500);
        }

        $data['title'] = ucfirst($data['title']);
        $data['thumbnail'] = $filePath . $fileName;

        $product = $request->user()->products()->create($data);

        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
