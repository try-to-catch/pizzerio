<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'icon'];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Category $category) {
            $category->slug = $category->slug ?? str($category->title)->slug();
        });
        static::updating(function (Category $category) {
            $category->slug = str($category->title)->slug();
        });
    }


    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function scopeLastSeven(Builder $query): Builder
    {
        return $query
            ->withWhereHas('products', function ($query) {
                $query->where('is_for_sale', true);
            })
            ->limit(7)
            ->latest('updated_at');

    }
}
