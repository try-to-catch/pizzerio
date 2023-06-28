<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsToMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
    ];

    public function products(): belongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity')->withTimestamps();
    }

    public function getTotalAttribute()
    {
        return $this->products->sum(fn($product) => $product->pivot->quantity * ($product->sale_price ?? $product->price));
    }

    public function getCountAttribute()
    {
        return $this->products->sum('pivot.quantity');
    }
}
