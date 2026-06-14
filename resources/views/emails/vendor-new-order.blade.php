<x-emails.components.layout subject="Pesanan Baru Masuk">
    <h2>Pesanan Baru Masuk! 🛒</h2>
    <p>Halo <strong>{{ $transaction->vendor?->user?->name ?? 'Vendor' }}</strong>,</p>
    <p>Anda menerima pesanan baru yang sudah dibayar oleh pelanggan:</p>

    <div class="info-box">
        <table class="info-table">
            <tr>
                <td class="label">No. Invoice</td>
                <td class="value">{{ $transaction->invoice_number }}</td>
            </tr>
            <tr>
                <td class="label">Pelanggan</td>
                <td class="value">{{ $transaction->customer->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Produk</td>
                <td class="value">{{ $transaction->product->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Check-in</td>
                <td class="value">{{ $transaction->check_in?->format('d M Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Jumlah</td>
                <td class="value">{{ $transaction->quantity }} pax</td>
            </tr>
        </table>

        <div class="total-row" style="display: flex; justify-content: space-between; align-items: center;">
            <span class="info-label" style="color: #fff; font-size: 16px;">Total</span>
            <span class="info-value" style="color: #fff; font-size: 16px;">{{ $transaction->formatted_total }}</span>
        </div>
    </div>

    <p>Silakan proses pesanan ini sesegera mungkin melalui dashboard vendor Anda.</p>

    <div style="text-align: center;">
        <a href="{{ route('vendor.orders.show', $transaction->id) }}" class="btn-primary">Lihat Detail Pesanan</a>
    </div>
</x-emails.components.layout>
