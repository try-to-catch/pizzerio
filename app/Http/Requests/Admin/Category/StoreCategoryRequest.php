<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->is_admin = true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'title' => ucfirst(strtolower($this->input('title'))),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'unique:categories'],
            'icon' => ['required', 'image'],
        ];
    }
}
