<x-emails.components.layout subject="Akun Vendor Disetujui">
    <h2>Selamat! Akun Vendor Anda Aktif 🎉</h2>
    <p>Halo <strong>{{ $vendor->name }}</strong>,</p>
    <p>Dengan senang hati kami informasikan bahwa akun vendor Anda di PesisirConnect telah <strong>disetujui</strong> oleh tim admin kami.</p>

    <div class="info-box">
        <table class="info-table">
            <tr>
                <td class="label">Nama Toko</td>
                <td class="value">{{ $vendor->vendor?->shop_name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Status</td>
                <td class="value" style="color: #16a34a;">✅ Disetujui</td>
            </tr>
            <tr>
                <td class="label">Tanggal Verifikasi</td>
                <td class="value">{{ now()->format('d M Y') }}</td>
            </tr>
        </table>
    </div>

    <p>Anda sekarang dapat mulai menambahkan produk dan menerima pesanan dari pelanggan. Silakan login ke dashboard vendor Anda untuk memulai.</p>

    <div style="text-align: center;">
        <a href="{{ route('vendor.dashboard') }}" class="btn-primary">Buka Dashboard Vendor</a>
    </div>

    <p style="font-size: 13px; color: #64748b; margin-top: 20px;">
        <strong>Tips:</strong> Lengkapi profil toko dan tambahkan foto produk berkualitas tinggi untuk menarik lebih banyak pelanggan.
    </p>
</x-emails.components.layout>
