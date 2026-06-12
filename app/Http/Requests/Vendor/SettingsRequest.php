<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $vendorId = auth()->user()->vendor->id ?? null;

        return [
            'shop_name'           => 'required|string|max:255|unique:vendors,shop_name,' . $vendorId,
            'business_type'       => 'nullable|string|max:100',
            'bio'                 => 'nullable|string|max:1000',
            'phone'               => 'required|string|max:20',
            'address'             => 'nullable|string|max:500',
            'city'                => 'nullable|string|max:100',
            'zip_code'            => 'nullable|string|max:10',
            'bank_name'           => 'nullable|string|max:100',
            'account_holder'      => 'nullable|string|max:255',
            'account_number'      => 'nullable|string|max:50',
            'logo'                => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'avatar'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'business_license'    => 'nullable|image|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            'auto_approve_orders' => 'boolean',
            'enable_notifications' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'shop_name.required' => 'Nama toko wajib diisi.',
            'shop_name.unique'   => 'Nama toko sudah digunakan.',
            'phone.required'     => 'Nomor telepon wajib diisi.',
        ];
    }
}
