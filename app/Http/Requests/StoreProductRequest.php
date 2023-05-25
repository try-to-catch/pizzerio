<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->is_admin = true;
    }


    protected function prepareForValidation(): void
    {
        $this->merge([
            'title' => ucwords(strtolower($this->input('title'))),
        ]);
    }


    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'unique:products'],
            'banner' => ['string', 'min:2', 'max:5', 'nullable'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'description' => ['required', 'string', 'min:50'],
            'ingredients' => ['required', 'string', 'min:20'],
            'is_for_sale' => ['required', 'boolean'],
            'price' => ['required', 'decimal:0,2'],
            'sale_price' => ['integer', 'decimal:0,2', 'nullable'],
            'priority' => ['required', 'integer', 'between:0,999'],
            'thumbnail' => ['required', 'image', 'dimensions:min_width=450,min_height=450'],
        ];
    }
}
