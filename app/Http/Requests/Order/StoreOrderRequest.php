<?php

namespace App\Http\Requests\Order;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'customer.name' => ['required', 'string', 'max:255'],
            'customer.phone' => ['required', 'string', 'max:255'],
            'customer.email' => ['required', 'string', 'max:255'],
            'destination.street' => ['required', 'string', 'max:255'],
            'destination.house' => ['nullable', 'string', 'max:255'],
            'destination.entrance' => ['nullable', 'string', 'max:255'],
            'destination.floor' => ['nullable', 'string', 'max:255'],
            'destination.apartment' => ['nullable', 'string', 'max:255'],
            'destination.intercom' => ['nullable', 'string', 'max:255'],
            'comment' => ['nullable', 'string'],
        ];
    }
}
