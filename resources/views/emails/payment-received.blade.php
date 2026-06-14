<x-emails.components.layout subject="Pembayaran Berhasil">
    <h2>Pembayaran Berhasil Diterima! ✅</h2>
    <p>Halo <strong>{{ $transaction->customer->name }}</strong>,</p>
    <p>Pembayaran Anda untuk pesanan berikut telah berhasil diverifikasi:</p>

    <div class="info-box">
        <table class="info-table">
            <tr>
                <td class="label">No. Invoice</td>
                <td class="value">{{ $transaction->invoice_number }}</td>
            </tr>
            <tr>
                <td class="label">Produk</td>
                <td class="value">{{ $transaction->product->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Metode Pembayaran</td>
                <td class="value">{{ ucfirst(str_replace('_', ' ', $transaction->midtrans_payment_type ?? $transaction->payment_method)) }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Bayar</td>
                <td class="value">{{ $transaction->paid_at?->format('d M Y, H:i') ?? now()->format('d M Y, H:i') }}</td>
            </tr>
        </table>

        <div class="total-row" style="display: flex; justify-content: space-between; align-items: center;">
            <span class="info-label" style="color: #fff; font-size: 16px;">Total Dibayar</span>
            <span class="info-value" style="color: #fff; font-size: 16px;">{{ $transaction->formatted_total }}</span>
        </div>
    </div>

    <p>Pesanan Anda sedang diproses oleh vendor. Anda akan menerima notifikasi lebih lanjut mengenai status pesanan.</p>

    <div style="text-align: center;">
        <a href="{{ route('dashboard') }}" class="btn-primary">Lihat Detail Pesanan</a>
    </div>
</x-emails.components.layout>
