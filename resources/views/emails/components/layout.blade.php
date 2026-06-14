<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'PesisirConnect' }}</title>
    <style>
        /* Reset */
        body, table, td, p, a { margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background-color: #f1f5f9; color: #1e293b; line-height: 1.6; -webkit-text-size-adjust: 100%; }
        img { border: 0; max-width: 100%; display: block; }
        /* Container */
        .email-wrapper { width: 100%; padding: 32px 16px; background-color: #f1f5f9; }
        .email-container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
        /* Header */
        .email-header { background: linear-gradient(135deg, #0284c7, #0ea5e9, #38bdf8); padding: 32px 24px; text-align: center; }
        .email-header h1 { color: #ffffff; font-size: 22px; font-weight: 700; letter-spacing: -0.02em; }
        .email-header p { color: rgba(255,255,255,.85); font-size: 13px; margin-top: 4px; }
        /* Body */
        .email-body { padding: 32px 24px; }
        .email-body h2 { font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 8px; }
        .email-body p { font-size: 14px; color: #475569; margin-bottom: 16px; }
        /* Info Box */
        .info-box { background-color: #f0f9ff; border: 1px solid #bae6fd; border-radius: 12px; padding: 20px; margin: 20px 0; }
        .info-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 13px; border-bottom: 1px solid #e0f2fe; }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #64748b; }
        .info-value { color: #0f172a; font-weight: 600; text-align: right; }
        /* Total */
        .total-row { background: linear-gradient(135deg, #0284c7, #0ea5e9); border-radius: 10px; padding: 16px 20px; margin-top: 16px; }
        .total-row .info-label, .total-row .info-value { color: #ffffff; font-size: 16px; }
        /* Button */
        .btn-primary { display: inline-block; background: linear-gradient(135deg, #0284c7, #0ea5e9); color: #ffffff !important; text-decoration: none; padding: 12px 32px; border-radius: 10px; font-size: 14px; font-weight: 600; margin: 20px 0; }
        .btn-primary:hover { opacity: .9; }
        /* Footer */
        .email-footer { background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 24px; text-align: center; }
        .email-footer p { font-size: 12px; color: #94a3b8; margin-bottom: 4px; }
        .email-footer a { color: #0ea5e9; text-decoration: none; }
        /* Responsive table fallback */
        table.info-table { width: 100%; border-collapse: collapse; }
        table.info-table td { padding: 8px 0; font-size: 13px; vertical-align: top; }
        table.info-table td.label { color: #64748b; width: 40%; }
        table.info-table td.value { color: #0f172a; font-weight: 600; text-align: right; }
        table.info-table tr { border-bottom: 1px solid #e0f2fe; }
        table.info-table tr:last-child { border-bottom: none; }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            {{-- Header --}}
            <div class="email-header">
                <h1>🌊 PesisirConnect</h1>
                <p>Platform Wisata Pesisir Lampung</p>
            </div>

            {{-- Body --}}
            <div class="email-body">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            <div class="email-footer">
                <p>&copy; {{ date('Y') }} PesisirConnect. Seluruh hak cipta dilindungi.</p>
                <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
                <p><a href="{{ url('/') }}">Kunjungi Website</a></p>
            </div>
        </div>
    </div>
</body>
</html>
