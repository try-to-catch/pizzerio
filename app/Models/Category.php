<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'icon'];

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
