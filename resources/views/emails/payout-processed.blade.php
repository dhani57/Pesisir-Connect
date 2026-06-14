<x-emails.components.layout subject="Payout Berhasil Diproses">
    <h2>Payout Berhasil Diproses! 🏦</h2>
    <p>Halo <strong>{{ $payout->vendor->user->name ?? 'Vendor' }}</strong>,</p>
    <p>Permintaan payout Anda telah berhasil diproses. Berikut rinciannya:</p>

    <div class="info-box">
        <table class="info-table">
            <tr>
                <td class="label">Jumlah Payout</td>
                <td class="value">Rp {{ number_format($payout->amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label">Bank Tujuan</td>
                <td class="value">{{ $payout->vendor->bank_name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Nomor Rekening</td>
                <td class="value">{{ $payout->vendor->account_number ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Atas Nama</td>
                <td class="value">{{ $payout->vendor->account_holder ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Proses</td>
                <td class="value">{{ $payout->processed_at?->format('d M Y, H:i') ?? now()->format('d M Y, H:i') }}</td>
            </tr>
        </table>
    </div>

    <p>Dana akan masuk ke rekening Anda dalam 1-3 hari kerja tergantung bank penerima.</p>

    <div style="text-align: center;">
        <a href="{{ route('vendor.earnings.index') }}" class="btn-primary">Lihat Riwayat Payout</a>
    </div>
</x-emails.components.layout>
