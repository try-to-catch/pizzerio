<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Models\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();

        $cart = Cart::query()->firstOrCreate(['session_id' => session()->getId()]);

        $order = $cart->order()->create([
            'customer_name' => $data['customer']['name'],
            'customer_phone_number' => $data['customer']['phone'],
            'customer_email' => $data['customer']['email'],
            'street' => $data['destination']['street'],
            'house' => $data['destination']['house'],
            'entrance' => $data['destination']['entrance'],
            'floor' => $data['destination']['floor'],
            'apartment' => $data['destination']['apartment'],
            'intercom' => $data['destination']['intercom'],
            'comment' => $data['comment'],
        ]);

        session()->regenerate();

        session(['last_order_id' => $order->id]);

        return to_route('order.thanksView');
    }

    public function thanksForOrder(): Response|RedirectResponse
    {
        if (Gate::denies('showThanksForOrder')) {
            return redirect()->route('home');
        }
        return Inertia::render('ThanksForOrder', ['order_id' => session('last_order_id')]);
    }
}
