<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'ingredients' => $this->ingredients,
            'description' => $this->description,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'priority' => $this->priority,
            'banner' => $this->banner,
            'is_for_sale' => $this->is_for_sale,
            'thumbnail' => '/storage/' . $this->thumbnail,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
            'user' => [
                'email' => $this->user->email
            ],
            'category' => [
                'title' => $this->category->title,
                'slug' => $this->category->slug
            ]
        ];
    }
}
