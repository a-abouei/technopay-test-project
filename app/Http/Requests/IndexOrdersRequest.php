<?php

namespace App\Http\Requests;

use App\Enums\OrderStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class IndexOrdersRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_national_code' => ['nullable', 'string'],
            'customer_mobile_number' => ['nullable', 'string', 'regex:/^(\+?[\d\s-]{7,15})$/'],
            'order_min_amount' => ['nullable', 'numeric'],
            'order_max_amount' => ['nullable', 'numeric'],
            'order_status' => ['nullable', 'string', new Enum(OrderStatus::class)]
        ];
    }
}
