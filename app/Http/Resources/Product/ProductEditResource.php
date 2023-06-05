<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductEditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'ingredients' => $this->ingredients,
            'description' => $this->description,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'priority' => $this->priority,
            'banner' => $this->banner,
            'is_for_sale' => (bool)$this->is_for_sale,
            'category_id' => $this->category_id
        ];
    }
}
