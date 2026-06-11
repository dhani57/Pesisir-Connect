# 🚀 PHASE 1: CORE CHECKOUT & PAYMENT INTEGRATION

**Objective:** Implementasi complete checkout flow dari product detail → checkout → payment → invoice → transaction history

**Timeline:** 1-2 hari
**Priority:** URGENT

---

## 📋 OVERVIEW FITUR YANG DIIMPLEMENTASI

```
User Flow:
Product Detail → Add to Cart → Checkout → Payment (Midtrans) 
  → Payment Success → Invoice → Transaction History
```

---

## 🎯 REQUIREMENTS TERINTEGRASI

### **1. CHECKOUT PAGE** 
**Route:** `POST /checkout/{product_slug}`
**Controller:** `CheckoutController@store` (NEW)
**View:** `checkout.blade.php` (NEW)

**Requirements:**
- Form dengan fields:
  - Check-in date (date picker)
  - Check-out date (date picker)
  - Jumlah tamu (number)
  - Catatan khusus (textarea)
  - Metode pembayaran (select: Midtrans, Bank Transfer manual)
- Display:
  - Product info (nama, harga, foto)
  - Kalkulasi otomatis: unit price × jumlah hari × jumlah tamu
  - Total price (besar & jelas)
  - Ringkasan booking
- Validasi:
  - Check-in < Check-out
  - Minimal jumlah tamu = 1
  - Stock/availability check
- Submit: Kirim ke Midtrans atau simpan sebagai pending transaction

**Models Updated:**
- `Transaction` model relationships dengan Product & User

---

### **2. MIDTRANS PAYMENT INTEGRATION**
**Service:** `PaymentService` (NEW)

**Requirements:**
- Setup Midtrans credentials di `.env`
- Generate Snap Token dari Midtrans API
- Payment flow:
  - Generate transaction → Get Snap URL → Redirect ke Midtrans
  - Handle callback dari Midtrans
  - Update transaction status berdasarkan payment result
- Status tracking:
  - `pending` → Waiting for payment
  - `paid` → Payment successful
  - `failed` → Payment failed
  - `expired` → Payment expired

**Integration Points:**
- `TransactionController@createPayment` (generate Snap token)
- `PaymentController@callback` (handle Midtrans webhook)
- `Transaction` model → `status`, `midtrans_transaction_id`, `midtrans_response` fields

---

### **3. PAYMENT SUCCESS PAGE**
**Route:** `GET /transaksi/{id}/sukses`
**Controller:** `TransactionController@success` (NEW)
**View:** `transaction-success.blade.php` (NEW)

**Requirements:**
- Display:
  - Konfirmasi pembayaran berhasil
  - Invoice number (generate otomatis)
  - Order details (product, tanggal, harga)
  - Payment method & proof
  - CTA button: "Lihat Invoice" & "Kembali ke Katalog"
- Data:
  - Fetch transaction berdasarkan ID
  - Check user authorization (only owner dapat akses)
- Email: Kirim email konfirmasi ke user

---

### **4. INVOICE PAGE**
**Route:** `GET /transaksi/{id}/invoice`
**Controller:** `TransactionController@invoice` (NEW)
**View:** `invoice.blade.php` (NEW)

**Requirements:**
- Display:
  - Invoice header (logo, nomor invoice, tanggal)
  - Customer info (nama, email, phone)
  - Product details (nama, qty, unit price, subtotal)
  - Tax & total (jika ada)
  - Payment method & payment date
  - Terms & conditions footer
- Functionality:
  - Download as PDF button (pakai DomPDF)
  - Print button
  - Email invoice button
- PDF Generation:
  - Install `barryvdh/laravel-dompdf`
  - Create `InvoiceResource` untuk format data
  - Template: `invoice-pdf.blade.php`

---

### **5. TRANSACTION HISTORY PAGE**
**Route:** `GET /transaksi` 
**Controller:** `TransactionController@index` (NEW)
**View:** `transaction-list.blade.php` (NEW)

**Requirements:**
- Display:
  - Table dengan columns: Invoice#, Product, Tanggal, Amount, Status, Actions
  - Status badge (pending/paid/failed/expired)
  - Pagination (20 items per page)
  - Filter: By status, By date range
  - Sort: By date (newest first)
- Actions per row:
  - View detail button
  - View invoice button
  - Cancel/Refund button (jika eligible)
- Empty state: Message jika belum ada transaksi
- Authorization: Only own transactions

---

### **6. TRANSACTION DETAIL PAGE**
**Route:** `GET /transaksi/{id}`
**Controller:** `TransactionController@show` (NEW)
**View:** `transaction-detail.blade.php` (NEW)

**Requirements:**
- Display:
  - Full transaction info
  - Product details & images
  - Booking dates (check-in, check-out)
  - Guest count
  - Price breakdown (unit price, quantity, total)
  - Payment status
  - Payment method & date
  - Special notes
- Actions:
  - Download invoice PDF
  - Print invoice
  - Edit (jika belum dibayar & masih bisa diedit)
  - Cancel button (jika eligible)
  - Contact vendor button

---

### **7. ADMIN DASHBOARD**
**Route:** `GET /admin` (Filament built-in)
**Update:** Existing Filament dashboard

**Requirements:**
- Widgets/Stats:
  - Total revenue (bulan ini, tahun ini)
  - Total transactions (pending, paid, cancelled)
  - Top products
  - Recent transactions (table)
  - New users this month
- Charts:
  - Revenue trend (last 30 days)
  - Transaction status distribution
  - Top selling products
- Quick actions:
  - View pending payments
  - New orders notification
  - Vendor reports
- Features:
  - Transaction management (view, search, filter)
  - Refund management
  - Payment reconciliation

---

### **8. VENDOR DASHBOARD**
**Route:** `GET /vendor/dashboard` (NEW)
**Controller:** `VendorDashboardController` (NEW)
**View:** `vendor-dashboard.blade.php` (NEW)

**Requirements:**
- Widgets/Stats:
  - My revenue
  - My transactions (pending, completed)
  - My products count
  - Rating & reviews
- Charts:
  - My sales trend
  - Product performance
- Table:
  - Recent transactions (filter: my products only)
  - My products list
- Features:
  - View transaction details
  - Send invoice to customer
  - Mark as ready/completed
  - Customer notes management
- Authorization:
  - Only vendor role dapat akses
  - Only see own transactions/products

---

## 🗄️ DATABASE UPDATES

### New Migrations:
```sql
-- Update transactions table
ALTER TABLE transactions ADD COLUMN invoice_number VARCHAR(255) UNIQUE;
ALTER TABLE transactions ADD COLUMN midtrans_transaction_id VARCHAR(255);
ALTER TABLE transactions ADD COLUMN midtrans_payment_type VARCHAR(100);
ALTER TABLE transactions ADD COLUMN midtrans_response JSON;
ALTER TABLE transactions ADD COLUMN paid_at TIMESTAMP NULLABLE;
ALTER TABLE transactions ADD COLUMN payment_method VARCHAR(100);
ALTER TABLE transactions MODIFY status VARCHAR(50) DEFAULT 'pending';
```

### Existing columns yang ada (check):
- user_id ✓
- product_id ✓
- check_in, check_out ✓
- quantity, guests ✓
- unit_price, total_price ✓
- status ✓

---

## 📁 FILE STRUCTURE (NEW FILES)

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Frontend/
│   │   │   ├── CheckoutController.php (NEW)
│   │   │   ├── TransactionController.php (NEW)
│   │   │   └── PaymentController.php (NEW)
│   │   ├── VendorDashboardController.php (NEW)
│   ├── Requests/
│   │   ├── CheckoutRequest.php (NEW)
│   │   ├── TransactionFilterRequest.php (NEW)
├── Services/
│   ├── PaymentService.php (NEW) - Midtrans integration
│   ├── InvoiceService.php (NEW) - Invoice generation
├── Resources/
│   ├── InvoiceResource.php (NEW) - Data transformer

resources/views/
├── frontend/
│   ├── checkout.blade.php (NEW)
│   ├── transaction-list.blade.php (NEW)
│   ├── transaction-detail.blade.php (NEW)
│   ├── transaction-success.blade.php (NEW)
│   ├── invoice.blade.php (NEW)
│   ├── invoice-pdf.blade.php (NEW)
├── vendor/
│   ├── dashboard.blade.php (NEW)
├── admin/
│   ├── dashboard.blade.php (UPDATE existing)

routes/
├── web.php (UPDATE with new routes)

config/
├── services.php (UPDATE - add Midtrans config)
```

---

## 🛣️ ROUTES NEEDED

```php
// Frontend - Checkout & Payment
Route::post('/checkout/{slug}', [CheckoutController::class, 'store'])->middleware('auth')->name('checkout.store');
Route::get('/checkout/{id}', [CheckoutController::class, 'show'])->middleware('auth')->name('checkout.show');

// Frontend - Payment
Route::post('/payment/{id}/process', [PaymentController::class, 'process'])->middleware('auth')->name('payment.process');
Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback'); // Midtrans webhook

// Frontend - Transactions
Route::get('/transaksi', [TransactionController::class, 'index'])->middleware('auth')->name('transaction.index');
Route::get('/transaksi/{id}', [TransactionController::class, 'show'])->middleware('auth')->name('transaction.show');
Route::get('/transaksi/{id}/invoice', [TransactionController::class, 'invoice'])->middleware('auth')->name('transaction.invoice');
Route::get('/transaksi/{id}/invoice/download', [TransactionController::class, 'downloadInvoice'])->middleware('auth')->name('transaction.invoice.download');
Route::get('/transaksi/{id}/sukses', [TransactionController::class, 'success'])->middleware('auth')->name('transaction.success');

// Vendor
Route::middleware(['auth', 'vendor'])->prefix('vendor')->group(function () {
    Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('vendor.dashboard');
    Route::get('/transaksi', [VendorDashboardController::class, 'transactions'])->name('vendor.transactions');
    Route::get('/transaksi/{id}', [VendorDashboardController::class, 'transactionDetail'])->name('vendor.transaction.detail');
});
```

---

## 🔐 MIDDLEWARE & AUTHORIZATION

**Create new middleware:**
- `IsVendor.php` - Check if user is vendor
- `IsAdmin.php` - Check if user is admin

**Authorization rules:**
- User hanya bisa lihat own transactions
- Vendor hanya bisa lihat transactions untuk products mereka
- Admin bisa lihat semua

---

## 📦 DEPENDENCIES NEEDED

```bash
# Payment gateway
composer require midtrans/midtrans-php

# PDF generation
composer require barryvdh/laravel-dompdf

# Email notifications
# (Already in Laravel by default)
```

---

## ✅ ACCEPTANCE CRITERIA

### Checkout Flow
- [ ] User bisa input booking details di checkout page
- [ ] Total price kalkulasi otomatis & benar
- [ ] Submit checkout → redirect ke Midtrans payment
- [ ] Validasi semua fields

### Payment
- [ ] Midtrans Snap popup/redirect works
- [ ] Payment success → update transaction status to 'paid'
- [ ] Payment failed → display error message
- [ ] Webhook callback handled correctly
- [ ] Transaction data saved with Midtrans response

### Invoice
- [ ] Invoice page display all required info
- [ ] Download as PDF works
- [ ] Invoice number unique & sequential
- [ ] Print functionality works

### Transaction History
- [ ] List all user transactions dengan pagination
- [ ] Filter by status works
- [ ] Sort by date works
- [ ] View details button works
- [ ] Invoice link works

### Admin Dashboard
- [ ] Stats widgets display correct data
- [ ] Charts render correctly
- [ ] Transaction table paginated & searchable
- [ ] Revenue calculation correct

### Vendor Dashboard
- [ ] Only shows own transactions
- [ ] Stats reflect vendor's data only
- [ ] Can view transaction details
- [ ] Authorization working (non-vendors can't access)

---

## 🎨 UI/UX NOTES

- **Checkout:** Clean form, visual progress indicator
- **Payment:** Clear loading state during Midtrans redirect
- **Success:** Celebratory message + invoice access
- **Invoice:** Professional looking, print-friendly
- **History:** Easy scanning with status badges (colors: green=paid, yellow=pending, red=failed)
- **Dashboard:** Analytics-focused, clear metrics
- **Responsive:** Mobile-first design

---

## 📧 EMAIL TEMPLATES NEEDED

1. **Order Confirmation** - After checkout created
2. **Payment Received** - After successful payment
3. **Invoice** - Attached to email
4. **Order Ready** - Vendor notification to customer
5. **Cancellation** - If order cancelled

---

## 🔍 TESTING CHECKLIST

**Manual Testing:**
- [ ] Complete checkout flow (product → payment → success)
- [ ] Try failed payment scenario
- [ ] Download PDF invoice
- [ ] Filter transactions by status
- [ ] Admin dashboard loads correctly
- [ ] Vendor dashboard shows only own data
- [ ] Mobile responsiveness

**Unit Tests:**
- [ ] PaymentService calculations
- [ ] Transaction status updates
- [ ] Authorization checks
- [ ] Invoice generation

---

## 📝 NOTES

1. **Midtrans Setup:**
   - Get Server Key & Client Key dari Midtrans dashboard
   - Add ke `.env`: `MIDTRANS_SERVER_KEY` & `MIDTRANS_CLIENT_KEY`
   - Test mode pertama kali

2. **PDF Library:**
   - DomPDF lebih reliable untuk generate invoice PDF
   - Pastikan GD library enabled di PHP

3. **Transaction Status Flow:**
   - `pending` → Created but not paid
   - `paid` → Successfully paid
   - `failed` → Payment failed
   - `expired` → Payment expired
   - `cancelled` → User cancelled
   - `completed` → Order delivered/used

4. **Invoice Numbering:**
   - Format: `INV-{YYYYMMDD}-{ID}`
   - Example: `INV-20260611-001`

5. **Security:**
   - Verify user ownership before showing transaction
   - Validate Midtrans webhook signature
   - Sanitize user input di checkout form

---

## 🚀 IMPLEMENTATION PRIORITY

1. **Week 1 (Day 1-2):**
   - Database migrations
   - Payment Service (Midtrans integration)
   - Checkout & Payment flow
   - Payment success page

2. **Week 1 (Day 3-4):**
   - Invoice page & PDF generation
   - Transaction detail page
   - Transaction list page

3. **Week 2 (Day 5-6):**
   - Admin dashboard
   - Vendor dashboard
   - Email notifications

4. **Week 2 (Day 7):**
   - Testing & bug fixes
   - UI/UX polish
   - Midtrans production setup

---

## 💡 FUTURE ENHANCEMENTS (Phase 2+)

- [ ] Shopping cart (multiple items)
- [ ] Promo codes/discounts
- [ ] Refund management
- [ ] Recurring bookings
- [ ] Payment plan (installment)
- [ ] Multiple payment methods (GCash, OVO, etc)
