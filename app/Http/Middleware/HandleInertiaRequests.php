<?php

namespace App\Http\Middleware;

use App\Http\Resources\Category\CategoryEssentialsResource;
use App\Http\Resources\User\UserMinResource;
use App\Models\Cart;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();
        $userData = $user ? UserMinResource::make($user)->resolve() : $user;

        $cart = Cart::query()
            ->with(['products' => function ($query) {
                $query->select('price', 'sale_price')->withPivot('quantity');
            }])
            ->firstOrCreate(['session_id' => session()->getId()]);

        $categories = Category::query()
            ->lastSeven()
            ->get(['id', 'title', 'icon', 'slug']);

        return array_merge(parent::share($request), [
            'message' => $request->session()->get('message'),
            'categories' => CategoryEssentialsResource::collection($categories)->resolve(),
            'auth' => [
                'user' => $userData,
            ],
            'cart' => [
                'count' => $cart->count ?? 0,
                'total' => $cart->total ?? 0,
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }
}
