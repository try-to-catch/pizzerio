<?php

namespace App\Policies;

class OrderPolicy
{
    public function showThanksForOrder(): bool
    {
        return session('last_order_id') !== null;
    }
}
