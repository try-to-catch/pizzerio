<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->is_admin = true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3'],
            'banner' => ['string', 'min:2', 'max:5', 'nullable'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'description' => ['required', 'string', 'min:50'],
            'ingredients' => ['required', 'string', 'min:20'],
            'is_for_sale' => ['required', 'boolean'],
            'price' => ['required', 'decimal:0,2'],
            'sale_price' => ['decimal:0,2', 'nullable'],
            'priority' => ['required', 'integer', 'between:0,999'],
            'thumbnail' => ['nullable', 'image', 'dimensions:min_width=300,min_height=300'],
        ];
    }
}
