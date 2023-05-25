<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'sale_price',
        'priority',
        'thumbnail',
        'ingredients',
        'description',
        'banner',
        'category_id',
        'is_for_sale'];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Product $product) {
            $product->slug = $product->slug ?? str($product->title)->slug();
        });

    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
