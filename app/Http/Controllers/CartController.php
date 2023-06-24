<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Resources\Cart\CartIndexResource;
use App\Models\Cart;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CartController extends Controller
{
    public function index(): Response
    {
        $cart = Cart::query()->firstOrCreate(['session_id' => session()->getId()]);

        $products = $cart->products()
            ->select(['id', 'slug', 'thumbnail', 'title', 'price', 'sale_price'])
            ->withPivot('quantity')
            ->get();

        return Inertia::render('Cart/Index', [
            'products' => CartIndexResource::collection($products)->resolve()
        ]);
    }

    public function add(AddToCartRequest $request): RedirectResponse
    {
        $productId = $request->validated()['product_id'];

        $cart = Cart::query()->firstOrCreate(['session_id' => session()->getId()]);

        $product = $cart->products()->where('product_id', $productId)->first();

        if ($product) {
            $product->pivot->quantity++;
            $product->pivot->save();
        } else {
            $cart->products()->attach($productId, ['quantity' => 1]);
        }

        $previousPath = url()->previous();
        $previousPath = preg_replace('/\?.*/', '', $previousPath);

        return redirect()->to($previousPath);
    }
}
