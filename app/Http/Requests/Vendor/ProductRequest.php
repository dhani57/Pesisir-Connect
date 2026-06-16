<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $vendorId = auth()->user()->vendor->id ?? null;
        $productId = $this->route('product');

        return [
            'name'             => [
                'required', 'string', 'max:255',
                Rule::unique('products')->where('vendor_id', $vendorId)->ignore($productId),
            ],
            'sku'              => [
                'required', 'string', 'max:100',
                Rule::unique('products')->where('vendor_id', $vendorId)->ignore($productId),
            ],
            'category_id'      => 'required|exists:categories,id',
            'short_description' => 'nullable|string|max:200',
            'description'      => 'required|string',
            'price'            => 'required|numeric|min:1',
            'price_unit'       => 'nullable|string|max:50',
            'discount'         => 'nullable|numeric|min:0',
            'discount_type'    => 'nullable|in:percentage,fixed',
            'stock'            => 'required|integer|min:0',
            'min_stock_alert'  => 'nullable|integer|min:0',
            'capacity'         => 'nullable|integer|min:0',
            'location'         => 'required|string|max:255',
            'address'          => 'nullable|string|max:500',
            'whatsapp'         => 'nullable|string|max:20',
            'thumbnail'        => ($this->isMethod('POST') ? 'required_without:thumbnail_url' : 'nullable') . '|image|mimes:jpg,jpeg,png,webp|max:5120',
            'thumbnail_url'    => ($this->isMethod('POST') ? 'required_without:thumbnail' : 'nullable') . '|url|max:1000',
            'gallery'          => 'nullable|array|max:10',
            'gallery.*'        => 'image|mimes:jpg,jpeg,png,webp|max:5120',
            'is_active'        => 'boolean',
            'is_featured'      => 'boolean',
            'status'           => 'nullable|in:active,inactive,draft',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords'    => 'nullable|string|max:255',
            'facilities'       => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'Nama produk wajib diisi.',
            'name.unique'          => 'Nama produk sudah digunakan untuk vendor ini.',
            'sku.required'         => 'Kode SKU wajib diisi.',
            'sku.unique'           => 'Kode SKU sudah digunakan.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'description.required' => 'Deskripsi produk wajib diisi.',
            'price.required'       => 'Harga wajib diisi.',
            'price.min'            => 'Harga harus lebih dari 0.',
            'stock.required'       => 'Stok wajib diisi.',
            'location.required'    => 'Lokasi wajib diisi.',
            'thumbnail.required_without'     => 'Gambar utama (file atau link) wajib diisi.',
            'thumbnail_url.required_without' => 'Gambar utama (file atau link) wajib diisi.',
            'thumbnail_url.url'              => 'Link gambar utama harus berupa URL yang valid.',
            'thumbnail.image'                => 'Gambar utama harus berupa file gambar.',
            'thumbnail.max'                  => 'Ukuran gambar maksimal 5MB.',
        ];
    }
}
