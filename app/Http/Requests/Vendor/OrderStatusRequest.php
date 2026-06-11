<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;

class OrderStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vendor_status' => 'required|in:pending,ready,completed,cancelled',
        ];
    }

    public function messages(): array
    {
        return [
            'vendor_status.required' => 'Status pesanan wajib dipilih.',
            'vendor_status.in'       => 'Status pesanan tidak valid.',
        ];
    }
}
