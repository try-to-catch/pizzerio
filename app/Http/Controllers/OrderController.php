<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Models\Cart;

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

        //TODO redirect to specific page with order details
        return redirect()->route('home');
    }
}
