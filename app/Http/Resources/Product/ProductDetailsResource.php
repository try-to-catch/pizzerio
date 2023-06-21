<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'ingredients' => $this->ingredients,
            'description' => $this->description,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'banner' => $this->banner,
            'thumbnail' => '/storage/' . $this->thumbnail,
        ];
    }
}
