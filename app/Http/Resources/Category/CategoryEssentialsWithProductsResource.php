<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\Product\ProductEssentialsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryEssentialsWithProductsResource extends JsonResource
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
            'icon' => '/storage/' . $this->icon,
            'products' => ProductEssentialsResource::collection($this->products)->resolve()
        ];
    }
}
