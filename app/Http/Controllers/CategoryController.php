<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $categories = Category::query()->select(['id', 'slug', 'title', 'icon', 'created_at', 'updated_at'])->get();

        return Inertia::render('Admin/Categories/Index', ['categories' => CategoryResource::collection($categories)->resolve()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Categories/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $icon = $request->file('icon');

        $file = Storage::disk('public')->put('/images/categories', $icon);

        if (!$file) {
            abort(500);
        }

        $category = $request->user()->categories()->create([
            'title' => ucfirst($data['title']),
            'icon' => 'images/categories/' . $icon->hashName(),
        ]);

        return redirect()->route('admin.categories.show', ['category' => $category->slug]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): Response
    {
        $numberOfRelatedProducts = 0;

        return Inertia::render('Admin/Categories/Show', [
            'category' => CategoryResource::make($category)->resolve(),
            'numberOfRelatedProducts' => $numberOfRelatedProducts]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): Response
    {
        return Inertia::render('Admin/Categories/Edit', [
            'category' => CategoryResource::make($category)->resolve()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response |RedirectResponse
    {
        $data = $request->validated();
        $icon = $request->file('icon');

        $dataForUpdate = [];

        if (isset($icon)) {
            Storage::disk('public')->delete($category->icon);
            $file = Storage::disk('public')->put('/images/categories', $icon);

            $dataForUpdate['icon'] = 'images/categories/' . $icon->hashName();

            if (!$file) {
                abort(500);
            }
        }

        if (array_key_exists('title', $data)) {
            if ($data['title'] !== $category->title) {
                $dataForUpdate['title'] = ucfirst($data['title']);
            }
        }

        if (count($dataForUpdate)) {
            try {

                $category->updateOrFail($dataForUpdate);
            } catch (QueryException $e) {
                return redirect()->back()->withErrors(['title' =>'The title has already been taken.']);
            }
        } else {
            $category->touch();
        }

        return redirect()->route('admin.categories.show', ['category' => $category->slug]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
