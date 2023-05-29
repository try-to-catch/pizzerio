<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'price' => $this->price,
            'is_for_sale' => $this->is_for_sale,
            'thumbnail' => '/storage/' . $this->thumbnail,
            'updated_at' => $this->updated_at->diffForHumans(),
            'user' => [
                'email' => $this->user_email
            ],
            'category' => [
                'category_title' => $this->category_title,
                'category_slug' => $this->category_slug
            ]
        ];
    }
}
