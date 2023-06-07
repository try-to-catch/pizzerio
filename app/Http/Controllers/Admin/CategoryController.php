<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Category\StoreIconAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\CategorySlugAndTitleResource;
use App\Models\Category;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class CategoryController extends Controller
{
    public function index(): Response
    {
        $categories = Category::query()
            ->select('categories.id', 'categories.slug', 'categories.title', 'categories.icon', 'categories.created_at', 'categories.updated_at', 'users.email')
            ->withCount('products')
            ->join('users', 'users.id', '=', 'categories.user_id')
            ->groupBy('categories.id')
            ->orderByDesc('categories.updated_at')
            ->get();

        $dataForResponse['categories'] = CategoryResource::collection($categories)->resolve();

        return Inertia::render('Admin/Categories/Index', $dataForResponse);
    }


    public function create(): Response
    {
        return Inertia::render('Admin/Categories/Create');
    }

    public function store(StoreCategoryRequest $request, StoreIconAction $storeIconAction): RedirectResponse
    {
        $data = $request->validated();
        $icon = $request->file('icon');

        $iconPath = $storeIconAction->handle($icon);

        $category = $request->user()->categories()->create([
            'title' => ucfirst($data['title']),
            'icon' => $iconPath,
        ]);

        return redirect()->route('admin.categories.show', ['category' => $category->slug]);
    }


    public function show(Category $category): Response
    {
        $category->load(['user' => function ($query) {
            $query->select('id', 'email');
        }])->loadCount('products');

        $category['email'] = $category['user']['email'];

        return Inertia::render('Admin/Categories/Show', [
            'category' => CategoryResource::make($category)->resolve()
        ]);
    }


    public function edit(Category $category): Response
    {
        return Inertia::render('Admin/Categories/Edit', [
            'category' => CategorySlugAndTitleResource::make($category)->resolve()
        ]);
    }


    public function update(UpdateCategoryRequest $request, Category $category, StoreIconAction $storeIconAction):
    \Illuminate\Contracts\Foundation\Application|ResponseFactory|Application|\Illuminate\Http\Response|RedirectResponse
    {
        $data = $request->validated();
        $icon = $request->file('icon');

        $dataForUpdate = [];

        if (isset($icon)) {
            $dataForUpdate['icon'] = $storeIconAction->handle($icon);
        }

        if (array_key_exists('title', $data)) {
            if ($data['title'] !== $category->title) {
                $dataForUpdate['title'] = ucfirst($data['title']);
            }
        }

        if (count($dataForUpdate)){
            try {
                $category->updateOrFail($dataForUpdate);
            } catch (QueryException|Throwable) {
                return redirect()->back()->withErrors(['title' => 'The title has already been taken.']);
            }
        }
        else{
            $category->touch();
        }

        return redirect()->route('admin.categories.show', ['category' => $category->slug]);
    }


    public function destroy(Category $category):
    \Illuminate\Contracts\Foundation\Application|ResponseFactory|Application|\Illuminate\Http\Response|RedirectResponse
    {
        Storage::disk('public')->delete($category->icon);
        if ($category->delete()) {
            return redirect()->route('admin.categories.index')->with(['message' => 'The category has been deleted successfully']);
        }

        return redirect()->back()
            ->withErrors(['message' => 'Something went wrong. Try again later or contact tech support']);
    }
}
