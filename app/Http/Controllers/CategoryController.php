<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function index(): Response
    {
        $categories = Category::query()
            ->select('categories.id', 'categories.slug', 'categories.title', 'categories.icon', 'categories.created_at', 'categories.updated_at', 'users.email')
            ->join('users', 'users.id', '=', 'categories.user_id')
            ->get();

        $dataForResponse['categories'] = CategoryResource::collection($categories)->resolve();

        $message = session('message');
        if ($message) {
            $dataForResponse['message'] = $message;
        }

        return Inertia::render('Admin/Categories/Index', $dataForResponse);
    }


    public function create(): Response
    {
        return Inertia::render('Admin/Categories/Create');
    }


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


    public function show(Category $category): Response
    {
        $category->load(['user' => function ($query) {
            $query->select('id', 'email');
        }]);

        $category['email'] = $category['user']['email'];

        $numberOfRelatedProducts = 0;

        return Inertia::render('Admin/Categories/Show', [
            'category' => CategoryResource::make($category)->resolve(),
            'numberOfRelatedProducts' => $numberOfRelatedProducts]);
    }


    public function edit(Category $category): Response
    {
        return Inertia::render('Admin/Categories/Edit', [
            'category' => CategoryResource::make($category)->resolve()]);
    }


    public function update(UpdateCategoryRequest $request, Category $category):
    \Illuminate\Contracts\Foundation\Application|ResponseFactory|Application|\Illuminate\Http\Response|RedirectResponse
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
                return redirect()->back()->withErrors(['title' => 'The title has already been taken.']);
            }
        } else {
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
