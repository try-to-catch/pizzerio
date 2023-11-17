<?php

namespace App\Policies;

class OrderPolicy
{
    public function showThanksForOrder(): bool
    {
        dd(session('last_order_id') !== null);
        return session('last_order_id') !== null;
    }
}
