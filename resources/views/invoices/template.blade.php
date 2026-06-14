<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice {{ $transaction->invoice_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; color: #1e293b; font-size: 12px; line-height: 1.5; }

        .invoice-container { max-width: 100%; padding: 40px; }

        /* Header */
        .header { display: table; width: 100%; margin-bottom: 40px; }
        .header-left { display: table-cell; width: 60%; vertical-align: top; }
        .header-right { display: table-cell; width: 40%; vertical-align: top; text-align: right; }
        .brand { font-size: 24px; font-weight: 700; color: #0284c7; letter-spacing: -0.5px; }
        .brand-sub { font-size: 11px; color: #64748b; margin-top: 4px; }
        .invoice-badge { display: inline-block; background: #0284c7; color: #ffffff; padding: 6px 16px; border-radius: 6px; font-size: 14px; font-weight: 700; letter-spacing: 1px; }

        /* Info blocks */
        .info-grid { display: table; width: 100%; margin-bottom: 30px; }
        .info-col { display: table-cell; width: 33.33%; vertical-align: top; padding-right: 16px; }
        .info-label { font-size: 10px; text-transform: uppercase; color: #94a3b8; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 4px; }
        .info-value { font-size: 12px; color: #1e293b; font-weight: 600; }
        .info-detail { font-size: 11px; color: #475569; margin-top: 2px; }

        /* Divider */
        .divider { border: none; border-top: 2px solid #e2e8f0; margin: 20px 0; }
        .divider-accent { border-top: 2px solid #0284c7; }

        /* Table */
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        .items-table thead th { background: #f1f5f9; padding: 10px 12px; text-align: left; font-size: 10px; text-transform: uppercase; color: #64748b; font-weight: 700; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0; }
        .items-table tbody td { padding: 12px; border-bottom: 1px solid #f1f5f9; font-size: 12px; }
        .items-table .text-right { text-align: right; }
        .items-table .text-center { text-align: center; }

        /* Total Box */
        .total-box { width: 280px; float: right; }
        .total-row { display: table; width: 100%; padding: 6px 0; }
        .total-label { display: table-cell; color: #64748b; font-size: 12px; }
        .total-value { display: table-cell; text-align: right; font-size: 12px; font-weight: 600; color: #1e293b; }
        .total-grand { background: #0284c7; color: #ffffff; padding: 10px 14px; border-radius: 6px; margin-top: 8px; }
        .total-grand .total-label, .total-grand .total-value { color: #ffffff; font-size: 14px; font-weight: 700; }

        /* Booking Info */
        .booking-box { background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px; padding: 16px; margin-bottom: 24px; }
        .booking-grid { display: table; width: 100%; }
        .booking-item { display: table-cell; width: 25%; }
        .booking-item-label { font-size: 10px; color: #64748b; text-transform: uppercase; font-weight: 700; }
        .booking-item-value { font-size: 13px; color: #0f172a; font-weight: 600; margin-top: 4px; }

        /* Footer */
        .footer { margin-top: 40px; text-align: center; padding-top: 20px; border-top: 1px solid #e2e8f0; }
        .footer p { font-size: 10px; color: #94a3b8; margin-bottom: 4px; }

        /* Clear float */
        .clearfix::after { content: ""; display: table; clear: both; }

        /* Status badges */
        .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 10px; font-weight: 700; text-transform: uppercase; }
        .badge-success { background: #dcfce7; color: #16a34a; }
        .badge-pending { background: #fef9c3; color: #ca8a04; }
        .badge-cancelled { background: #fee2e2; color: #dc2626; }

        @if($transaction->notes)
        .notes { background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 12px; margin-bottom: 24px; }
        .notes-title { font-size: 11px; font-weight: 700; color: #92400e; margin-bottom: 4px; }
        .notes-text { font-size: 11px; color: #78350f; }
        @endif
    </style>
</head>
<body>
    <div class="invoice-container">
        {{-- Header --}}
        <div class="header">
            <div class="header-left">
                <div class="brand">🌊 PesisirConnect</div>
                <div class="brand-sub">Platform Wisata Pesisir Lampung</div>
                <div class="brand-sub" style="margin-top: 2px;">{{ $platformUrl }}</div>
            </div>
            <div class="header-right">
                <div class="invoice-badge">INVOICE</div>
                <div style="margin-top: 10px; font-size: 11px; color: #64748b;">
                    {{ $invoiceDate->format('d M Y') }}
                </div>
            </div>
        </div>

        {{-- Invoice Meta --}}
        <div class="info-grid">
            <div class="info-col">
                <div class="info-label">No. Invoice</div>
                <div class="info-value">{{ $transaction->invoice_number }}</div>
            </div>
            <div class="info-col">
                <div class="info-label">Pelanggan</div>
                <div class="info-value">{{ $transaction->customer->name ?? '-' }}</div>
                <div class="info-detail">{{ $transaction->customer->email ?? '-' }}</div>
            </div>
            <div class="info-col">
                <div class="info-label">Vendor</div>
                <div class="info-value">{{ $transaction->vendor?->user?->name ?? '-' }}</div>
                <div class="info-detail">{{ $transaction->vendor?->shop_name ?? '-' }}</div>
            </div>
        </div>

        <hr class="divider divider-accent">

        {{-- Booking Details --}}
        <div class="booking-box">
            <div class="booking-grid">
                <div class="booking-item">
                    <div class="booking-item-label">Check-in</div>
                    <div class="booking-item-value">{{ $transaction->check_in?->format('d M Y') ?? '-' }}</div>
                </div>
                <div class="booking-item">
                    <div class="booking-item-label">Check-out</div>
                    <div class="booking-item-value">{{ $transaction->check_out?->format('d M Y') ?? '-' }}</div>
                </div>
                <div class="booking-item">
                    <div class="booking-item-label">Durasi</div>
                    <div class="booking-item-value">{{ $transaction->duration }} Hari</div>
                </div>
                <div class="booking-item">
                    <div class="booking-item-label">Status</div>
                    <div class="booking-item-value">
                        <span class="badge {{ match($transaction->status) { 'paid' => 'badge-success', 'pending' => 'badge-pending', default => 'badge-cancelled' } }}">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Items Table --}}
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 50%;">Produk / Layanan</th>
                    <th class="text-center" style="width: 10%;">Qty</th>
                    <th class="text-center" style="width: 10%;">Tamu</th>
                    <th class="text-right" style="width: 15%;">Harga Satuan</th>
                    <th class="text-right" style="width: 15%;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div style="font-weight: 600;">{{ $transaction->product->name ?? '-' }}</div>
                        <div style="font-size: 10px; color: #64748b; margin-top: 2px;">
                            {{ $transaction->product->category->name ?? '' }}
                            @if($transaction->product->location)
                                · {{ $transaction->product->location }}
                            @endif
                        </div>
                    </td>
                    <td class="text-center">{{ $transaction->quantity }}</td>
                    <td class="text-center">{{ $transaction->guests }}</td>
                    <td class="text-right">Rp {{ number_format($transaction->unit_price, 0, ',', '.') }}</td>
                    <td class="text-right" style="font-weight: 600;">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Total Box --}}
        <div class="clearfix">
            <div class="total-box">
                <div class="total-row">
                    <span class="total-label">Subtotal</span>
                    <span class="total-value">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="total-row">
                    <span class="total-label">Metode Pembayaran</span>
                    <span class="total-value">{{ ucfirst(str_replace('_', ' ', $transaction->midtrans_payment_type ?? $transaction->payment_method ?? '-')) }}</span>
                </div>
                <div class="total-grand">
                    <span class="total-label">Total Pembayaran</span>
                    <span class="total-value">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        {{-- Notes --}}
        @if($transaction->notes)
            <div style="clear: both; padding-top: 24px;"></div>
            <div class="notes">
                <div class="notes-title">📝 Catatan Pelanggan</div>
                <div class="notes-text">{{ $transaction->notes }}</div>
            </div>
        @endif

        {{-- Footer --}}
        <div class="footer">
            <p><strong>{{ $platformName }}</strong> — Platform Wisata Pesisir Lampung</p>
            <p>Invoice ini dihasilkan secara otomatis dan sah tanpa tanda tangan.</p>
            <p>{{ $platformUrl }}</p>
        </div>
    </div>
</body>
</html>
