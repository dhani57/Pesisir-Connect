<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;

class VendorRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'shop_name'        => 'required|string|max:255|unique:vendors,shop_name',
            'phone'            => 'required|string|max:20|regex:/^[0-9+\-\s()]+$/',
            'business_type'    => 'nullable|string|max:100',
            'address'          => 'nullable|string|max:500',
            'city'             => 'nullable|string|max:100',
            'zip_code'         => 'nullable|string|max:10',
            'bank_name'        => 'nullable|string|max:100',
            'account_holder'   => 'nullable|string|max:255',
            'account_number'   => 'nullable|string|max:50',
            'bio'              => 'nullable|string|max:1000',
            'logo'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'business_license' => 'nullable|image|mimes:jpg,jpeg,png,webp,pdf|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'shop_name.required' => 'Nama toko wajib diisi.',
            'shop_name.unique'   => 'Nama toko sudah digunakan.',
            'phone.required'     => 'Nomor telepon wajib diisi.',
            'phone.regex'        => 'Format nomor telepon tidak valid.',
            'logo.image'         => 'Logo harus berupa file gambar.',
            'logo.max'           => 'Ukuran logo maksimal 5MB.',
        ];
    }
}
