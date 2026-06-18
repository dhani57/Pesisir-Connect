<x-emails.components.layout subject="Pesanan Berhasil Dibuat">
    <h2>Pesanan Anda Berhasil Dibuat!</h2>
    <p>Halo <strong>{{ $transaction->customer->name }}</strong>,</p>
    <p>Terima kasih telah memesan melalui PesisirConnect. Berikut detail pesanan Anda:</p>

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
                <td class="label">Vendor</td>
                <td class="value">{{ $transaction->vendor?->user?->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Check-in</td>
                <td class="value">{{ $transaction->check_in?->format('d M Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Check-out</td>
                <td class="value">{{ $transaction->check_out?->format('d M Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Jumlah</td>
                <td class="value">{{ $transaction->quantity }} pax</td>
            </tr>
            <tr>
                <td class="label">Harga Satuan</td>
                <td class="value">Rp {{ number_format($transaction->unit_price, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="total-row" style="display: flex; justify-content: space-between; align-items: center;">
            <span class="info-label" style="color: #fff; font-size: 16px;">Total Pembayaran</span>
            <span class="info-value" style="color: #fff; font-size: 16px;">{{ $transaction->formatted_total }}</span>
        </div>
    </div>

    <p>Status pesanan Anda saat ini: <strong>Menunggu Pembayaran</strong>. Silakan segera selesaikan pembayaran agar pesanan Anda dapat diproses.</p>

    <div style="text-align: center;">
        <a href="{{ route('dashboard') }}" class="btn-primary">Lihat Pesanan Saya</a>
    </div>
</x-emails.components.layout>
