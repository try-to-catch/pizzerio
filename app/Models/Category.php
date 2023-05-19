<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;

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
}
