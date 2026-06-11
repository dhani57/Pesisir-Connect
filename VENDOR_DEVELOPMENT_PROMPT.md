# 👨‍💼 VENDOR FEATURE DEVELOPMENT - COMPREHENSIVE PROMPT

**Objective:** Implementasi complete vendor ecosystem dari registration → dashboard → product management → order management → analytics

**Priority:** HIGH (Critical for marketplace model)

---

## 📋 VENDOR FEATURES OVERVIEW

```
Vendor Onboarding → Vendor Dashboard → Product Management → Order Management → Analytics & Reports
```

---

## 🎯 REQUIREMENTS TERINTEGRASI

### **1. VENDOR ROLE & REGISTRATION**
**Route:** `GET/POST /vendor/register` (NEW)
**Controller:** `VendorRegistrationController` (NEW)
**View:** `vendor-register.blade.php` (NEW)

**Requirements:**
- Registration form fields:
  - Company/Shop name (required, unique)
  - Owner name
  - Email (use existing auth email)
  - Phone number (required)
  - Business type/category
  - Bank account (for commission payment):
    - Bank name
    - Account holder
    - Account number
  - Address (full address)
  - City/Province
  - ZIP code
  - Business license/permit (optional - upload image)
  - Avatar/Logo (optional)
  - Business description/bio
- Validasi:
  - Email unique
  - Shop name unique
  - Valid phone number
  - Valid bank account format
  - File upload (jika ada)
- Process:
  - Create user with `role = 'vendor'`
  - Create vendor profile di table `vendors` (NEW)
  - Send verification email
  - Redirect ke dashboard
  - Set status: `pending_approval` (admin needs to verify)

**Models:**
- Create `Vendor` model (NEW)
  - Relationship: `belongsTo(User)`
  - Fields: shop_name, phone, business_type, bank_name, account_holder, account_number, address, city, zip_code, logo, bio, status, is_approved, verified_at, created_at

---

### **2. VENDOR DASHBOARD**
**Route:** `GET /vendor/dashboard`
**Controller:** `VendorDashboardController@index` (NEW)
**View:** `vendor/dashboard.blade.php` (NEW)

**Requirements:**
- Header section:
  - Shop name & avatar
  - Shop status badge (pending/approved/suspended)
  - Quick stats badges:
    - Total earnings this month
    - Pending orders count
    - Average rating
    - Total products

- Main widgets (left column):
  - **Revenue Widget**
    - Revenue this month
    - Revenue last month
    - Revenue this year
    - Growth percentage
  - **Orders Widget**
    - Total pending orders
    - Ready to ship count
    - Completed orders this month
    - Cancelled orders count
  - **Products Widget**
    - Total products
    - Out of stock count
    - Top selling product
    - CTA: Add new product

- Right column:
  - **Recent Orders Table**
    - Order ID, Customer, Product, Amount, Status, Date
    - Limit 10 rows
    - CTA buttons: View detail, Mark ready, Cancel
  - **Top Products**
    - Product name, Sales count, Revenue
    - Limit 5 rows
    - CTA: Edit product

- Charts (bottom section):
  - **Sales Trend Chart** (last 30 days)
    - Line chart: Daily sales amount
    - Y-axis: Rupiah, X-axis: Dates
  - **Order Status Distribution** (Pie chart)
    - Pending, Ready, Completed, Cancelled
  - **Top 5 Products** (Bar chart)
    - Product name vs sales amount

- Quick actions bar:
  - Add new product button
  - View all orders button
  - View all products button
  - Settings button
  - View shop profile button

**Authorization:**
- Only vendor role can access
- Can only see own data

---

### **3. PRODUCT MANAGEMENT (VENDOR)**
**Route:** 
- `GET /vendor/products` (list)
- `GET /vendor/products/create` (create form)
- `POST /vendor/products` (store)
- `GET /vendor/products/{id}/edit` (edit form)
- `PUT/PATCH /vendor/products/{id}` (update)
- `DELETE /vendor/products/{id}` (delete)

**Controller:** `VendorProductController` (NEW)
**Views:**
- `vendor/products/index.blade.php` (NEW)
- `vendor/products/create.blade.php` (NEW)
- `vendor/products/edit.blade.php` (NEW)

**Requirements:**

#### **List Products Page:**
- Table columns:
  - Product image (thumbnail)
  - Product name
  - SKU/Code
  - Price
  - Stock quantity
  - Status (active/inactive)
  - Created date
  - Actions (Edit, Delete, Toggle status)
- Features:
  - Pagination (20 per page)
  - Search by name/SKU
  - Filter by status (active/inactive)
  - Sort by (name, price, stock, date)
  - Bulk actions: Delete, Change status
  - Empty state message
- CTA:
  - Add new product button
  - Excel import (optional)

#### **Create/Edit Product Form:**
- Basic Info:
  - Product name (required)
  - SKU/Code (required, unique per vendor)
  - Category (select from categories, required)
  - Short description (max 200 char)
  - Full description (textarea)
- Pricing:
  - Unit price (required, decimal)
  - Discount (optional, percentage or fixed)
  - Calculated discounted price (display)
- Inventory:
  - Stock quantity (required)
  - Min stock alert level
  - Out of stock action (hide/show unavailable)
- Images:
  - Main image (required, upload)
  - Gallery images (multiple, optional)
  - Image preview
  - Delete image button
- Settings:
  - Is active (toggle)
  - Is featured (toggle)
  - Meta title (SEO)
  - Meta description (SEO)
  - Meta keywords (SEO)
- Validasi:
  - All required fields
  - Product name unique per vendor
  - SKU unique per vendor
  - Price > 0
  - Stock >= 0
  - Valid image format (jpg, png, webp)
  - Image size < 5MB
- Save options:
  - Save & publish button
  - Save as draft button
  - Save & add another button

**Models:**
- Update `Product` model:
  - Add `vendor_id` field
  - Relationship: `belongsTo(Vendor)` or `belongsTo(User)` dengan vendor role
  - Add: `status` (active/inactive/draft), `meta_title`, `meta_description`, `meta_keywords`, `is_featured`, `min_stock_alert`

---

### **4. ORDER MANAGEMENT (VENDOR)**
**Route:**
- `GET /vendor/orders` (list)
- `GET /vendor/orders/{id}` (detail)
- `PATCH /vendor/orders/{id}/status` (update status)
- `POST /vendor/orders/{id}/send-invoice` (send invoice)
- `POST /vendor/orders/{id}/notes` (add notes)

**Controller:** `VendorOrderController` (NEW)
**Views:**
- `vendor/orders/index.blade.php` (NEW)
- `vendor/orders/show.blade.php` (NEW)

**Requirements:**

#### **Orders List:**
- Table columns:
  - Order ID/Invoice number
  - Customer name
  - Product name
  - Booking dates (check-in - check-out)
  - Amount
  - Payment status (paid/pending/failed)
  - Order status (pending/ready/completed/cancelled)
  - Customer rating (if completed)
  - Actions (View, Update status, Send invoice, Contact)
- Features:
  - Pagination
  - Search by order ID, customer name, product
  - Filter by:
    - Order status (pending, ready, completed, cancelled)
    - Payment status (paid, pending, failed)
    - Date range
  - Sort by (date, amount, status)
  - Bulk actions: Change status, Send invoice
  - Empty state
- Display:
  - Total count per status
  - Today's orders count
  - Pending payment count (alert badge)

#### **Order Detail Page:**
- Header:
  - Order ID & date
  - Customer name & contact
  - Order status badge
  - Payment status badge
- Main content:
  - **Product Section:**
    - Product image
    - Product name & link
    - Check-in date
    - Check-out date
    - Guest count
    - Unit price & quantity
    - Total price
  - **Customer Section:**
    - Customer name
    - Email
    - Phone
    - Special notes/requests
  - **Payment Section:**
    - Payment method
    - Amount paid
    - Payment date
    - Payment proof/status
  - **Timeline/Activity:**
    - Order created
    - Payment received
    - Vendor notes
    - Order completed
    - Customer review (if any)
- Vendor Actions:
  - **Status dropdown:**
    - Pending → Ready (untuk konfirmasi)
    - Ready → Completed (after customer done)
    - Any status → Cancelled
  - **Send Invoice button**
    - Re-send invoice to customer email
  - **Add Notes button**
    - Vendor bisa tambah internal notes
    - Notes hanya visible ke vendor
  - **Contact Customer button**
    - Trigger modal: Send message/email template
  - **Request Review/Rating button**
    - Send reminder untuk customer rate
  - **Print/Download Invoice**

---

### **5. VENDOR PROFILE & SETTINGS**
**Route:**
- `GET /vendor/profile` (view)
- `GET /vendor/settings` (edit form)
- `PUT/PATCH /vendor/settings` (update)

**Controller:** `VendorSettingsController` (NEW)
**Views:**
- `vendor/profile.blade.php` (NEW - public, customer bisa lihat)
- `vendor/settings.blade.php` (NEW - private)

**Requirements:**

#### **Public Vendor Profile:**
- Display:
  - Shop name & logo
  - Shop avatar
  - Shop description/bio
  - Average rating & review count
  - Total products
  - Join date
  - Response time
  - Quick stats (based on reviews)
- Sections:
  - Featured products (top 4)
  - Recent reviews (last 10)
  - Contact vendor link
  - View all products link

#### **Vendor Settings Page:**
- **Account Section:**
  - Shop name (editable)
  - Business type
  - Bio/Description
  - Logo upload
  - Avatar upload
  - Delete logo/avatar
- **Contact Info Section:**
  - Email (read-only, dari user account)
  - Phone number
  - Address
  - City/Province
  - ZIP code
- **Banking Info Section:**
  - Bank name
  - Account holder
  - Account number
  - Hidden input (show on edit)
- **Business Info Section:**
  - Business license/permit (upload, view)
  - Business category
  - Business hours (optional)
- **Commission/Payment Section:**
  - Commission rate (read-only, from system)
  - Total earned this month (read-only)
  - Total earned all time (read-only)
  - Payment history link
- **Preferences Section:**
  - Auto-approve orders (toggle)
  - Enable notifications (toggle)
  - Notification channels (email, SMS)
  - Payment reminder interval
  - Review reminder interval
- Buttons:
  - Save changes
  - Reset form
  - Change password button
  - Deactivate shop button (conditional)

---

### **6. VENDOR ANALYTICS & REPORTS**
**Route:** `GET /vendor/analytics`
**Controller:** `VendorAnalyticsController` (NEW)
**View:** `vendor/analytics.blade.php` (NEW)

**Requirements:**
- **Date range filter:** Last 7 days, 30 days, 90 days, custom range
- **Key metrics (top section):**
  - Total sales (revenue)
  - Total orders
  - Average order value
  - Conversion rate
  - Total customers
  - Repeat customers %
  - Average rating
  - Response rate
- **Charts:**
  1. **Revenue Trend** (Line chart)
     - X-axis: Dates
     - Y-axis: Amount
     - Comparison: Current period vs previous period
  2. **Orders Trend** (Line chart)
     - X-axis: Dates
     - Y-axis: Order count
  3. **Product Performance** (Bar/Table)
     - Top 10 products by sales
     - Columns: Name, Sales count, Revenue, Avg rating
  4. **Customer Segments** (Donut chart)
     - New vs returning customers
  5. **Payment Methods** (Pie chart)
     - Distribution of payment methods used
  6. **Order Status Distribution** (Horizontal bar)
     - Pending, Ready, Completed, Cancelled counts
- **Data Tables:**
  - Recent transactions detailed table
  - Top customers table
  - Product sales details table
- **Export Options:**
  - Export to Excel (sales data)
  - Export to PDF (reports)

---

### **7. VENDOR REVIEWS & RATINGS**
**Route:** `GET /vendor/reviews`
**Controller:** `VendorReviewController` (NEW)
**View:** `vendor/reviews/index.blade.php` (NEW)

**Requirements:**
- **Reviews List:**
  - Display reviews from customers
  - Columns:
    - Customer name
    - Rating (stars)
    - Review text
    - Product name
    - Date
    - Status (published/hidden)
  - Sorting: By rating, by date, by helpful count
  - Filter: By rating (5 star, 4 star, etc), by date range
  - Pagination
- **Review Details:**
  - Full review text
  - Customer name & avatar
  - Product link
  - Transaction link
  - Helpful count
  - Actions:
    - Hide review (vendor bisa hide review yang ga bagus)
    - Delete review (request delete)
    - Reply to review (vendor bisa balas review)
- **Statistics:**
  - Average rating (overall)
  - Rating distribution chart
  - Review count by rating
  - Response rate %

---

### **8. VENDOR FILAMENT ADMIN PANEL**
**Route:** `/admin/vendors` (Filament resource)
**Create:** `VendorResource.php` (NEW - Filament)

**Requirements:**
- **Admin can:**
  - View all vendors
  - Approve/reject new vendors
  - View vendor details
  - Edit vendor info
  - Suspend/activate vendors
  - View vendor earnings
  - View vendor transactions
  - Generate vendor reports
  - Manage vendor commission
- **Vendor List Fields:**
  - Shop name
  - Owner name
  - Email
  - Phone
  - Status (pending/approved/suspended)
  - Approval date
  - Total earnings
  - Total products
  - Total orders
  - Average rating
  - Actions
- **Vendor Detail Page:**
  - All vendor info
  - Documents (license, etc)
  - Earnings breakdown
  - Order history
  - Commission settings
  - Status management
  - Payment history
  - Notes from admin
- **Actions:**
  - Approve vendor
  - Suspend vendor
  - Edit commission rate
  - Send message/notification
  - View earnings
  - Manual payout button

---

### **9. VENDOR EARNINGS & COMMISSION**
**Route:** `GET /vendor/earnings`
**Controller:** `VendorEarningsController` (NEW)
**View:** `vendor/earnings/index.blade.php` (NEW)

**Requirements:**
- **Earnings Summary:**
  - This month earnings
  - Last month earnings
  - Total all-time earnings
  - Pending earnings (not yet paid)
  - Commission rate (%)
- **Earnings Breakdown:**
  - By product
  - By customer
  - By date range
- **Payment History:**
  - Table with:
    - Payment date
    - Amount
    - Period (date range of sales)
    - Status (paid/pending)
    - Bank/Payment method
    - Transaction ID
  - Filter by status, date
- **Current Pending Earnings:**
  - Next payout date
  - Minimum payout threshold
  - Can request payout (if amount > threshold)
- **Commission Details:**
  - Commission rate explanation
  - How commission calculated
  - Example calculation
  - Terms & conditions

---

### **10. VENDOR NOTIFICATIONS**
**Routes:** 
- `GET /vendor/notifications`
- `PATCH /vendor/notifications/{id}/read`
- `DELETE /vendor/notifications/{id}`

**Controller:** `VendorNotificationController` (NEW)
**View:** `vendor/notifications.blade.php` (NEW)

**Requirements:**
- **Notification Types:**
  - New order received
  - Payment received
  - Payment pending (reminder)
  - Payout processed
  - New review received
  - Review reply mention
  - Product out of stock
  - Admin message
  - Approval status update
- **Notifications List:**
  - Bell icon in navbar (shows unread count)
  - Dropdown preview (last 5 notifications)
  - Full page with pagination
  - Mark as read button
  - Delete button
  - Read/unread status indicator
- **Notification Settings:**
  - Enable/disable notifications per type
  - Email notifications toggle
  - Push notifications toggle
  - Quiet hours setting

---

## 🗄️ DATABASE SCHEMA

### **New Tables:**

```sql
-- Vendors table
CREATE TABLE vendors (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL UNIQUE,
    shop_name VARCHAR(255) NOT NULL UNIQUE,
    business_type VARCHAR(100),
    phone VARCHAR(20),
    address TEXT,
    city VARCHAR(100),
    zip_code VARCHAR(10),
    bank_name VARCHAR(100),
    account_holder VARCHAR(255),
    account_number VARCHAR(50),
    logo VARCHAR(255),
    avatar VARCHAR(255),
    bio TEXT,
    status VARCHAR(50) DEFAULT 'pending_approval', -- pending_approval, approved, suspended
    is_approved BOOLEAN DEFAULT FALSE,
    verified_at TIMESTAMP NULL,
    commission_rate DECIMAL(5,2) DEFAULT 10, -- percentage
    total_earnings DECIMAL(15,2) DEFAULT 0,
    response_time_hours INT DEFAULT 24,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX(status),
    INDEX(is_approved)
);

-- Update products table
ALTER TABLE products ADD COLUMN vendor_id BIGINT;
ALTER TABLE products ADD COLUMN status VARCHAR(50) DEFAULT 'active'; -- active, inactive, draft
ALTER TABLE products ADD COLUMN min_stock_alert INT DEFAULT 10;
ALTER TABLE products ADD COLUMN meta_title VARCHAR(255);
ALTER TABLE products ADD COLUMN meta_description TEXT;
ALTER TABLE products ADD COLUMN meta_keywords VARCHAR(255);
ALTER TABLE products ADD COLUMN is_featured BOOLEAN DEFAULT FALSE;
ALTER TABLE products ADD FOREIGN KEY (vendor_id) REFERENCES vendors(id) ON DELETE CASCADE;
ALTER TABLE products ADD INDEX(vendor_id);

-- Vendor commission logs (for tracking earnings)
CREATE TABLE vendor_commission_logs (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    vendor_id BIGINT NOT NULL,
    transaction_id BIGINT NOT NULL,
    amount DECIMAL(15,2),
    commission_percentage DECIMAL(5,2),
    commission_amount DECIMAL(15,2),
    period_start DATE,
    period_end DATE,
    status VARCHAR(50) DEFAULT 'calculated', -- calculated, paid, failed
    paid_at TIMESTAMP NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (vendor_id) REFERENCES vendors(id),
    FOREIGN KEY (transaction_id) REFERENCES transactions(id),
    INDEX(vendor_id),
    INDEX(status)
);

-- Vendor payouts
CREATE TABLE vendor_payouts (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    vendor_id BIGINT NOT NULL,
    amount DECIMAL(15,2),
    period_start DATE,
    period_end DATE,
    bank_name VARCHAR(100),
    account_number VARCHAR(50),
    status VARCHAR(50) DEFAULT 'pending', -- pending, processing, paid, failed
    reference_number VARCHAR(100),
    notes TEXT,
    paid_at TIMESTAMP NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (vendor_id) REFERENCES vendors(id),
    INDEX(status),
    INDEX(paid_at)
);

-- Vendor reviews (separate from product reviews)
CREATE TABLE vendor_reviews (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    vendor_id BIGINT NOT NULL,
    user_id BIGINT NOT NULL,
    transaction_id BIGINT NOT NULL,
    rating INT (1-5),
    review_text TEXT,
    helpful_count INT DEFAULT 0,
    is_hidden BOOLEAN DEFAULT FALSE,
    vendor_reply TEXT,
    vendor_reply_at TIMESTAMP NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (vendor_id) REFERENCES vendors(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (transaction_id) REFERENCES transactions(id),
    INDEX(vendor_id),
    INDEX(rating)
);

-- Update transactions table
ALTER TABLE transactions ADD COLUMN vendor_id BIGINT;
ALTER TABLE transactions ADD COLUMN vendor_notes TEXT;
ALTER TABLE transactions ADD COLUMN vendor_status VARCHAR(50) DEFAULT 'pending'; -- pending, ready, completed, cancelled
ALTER TABLE transactions ADD COLUMN completed_at TIMESTAMP NULL;
ALTER TABLE transactions ADD FOREIGN KEY (vendor_id) REFERENCES vendors(id);
ALTER TABLE transactions ADD INDEX(vendor_id);
```

---

## 📁 FILE STRUCTURE

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Vendor/
│   │   │   ├── VendorDashboardController.php (NEW)
│   │   │   ├── VendorProductController.php (NEW)
│   │   │   ├── VendorOrderController.php (NEW)
│   │   │   ├── VendorSettingsController.php (NEW)
│   │   │   ├── VendorAnalyticsController.php (NEW)
│   │   │   ├── VendorReviewController.php (NEW)
│   │   │   ├── VendorEarningsController.php (NEW)
│   │   │   ├── VendorNotificationController.php (NEW)
│   │   │   ├── VendorRegistrationController.php (NEW)
│   ├── Middleware/
│   │   ├── IsVendor.php (NEW)
│   ├── Requests/
│   │   ├── Vendor/
│   │   │   ├── VendorRegistrationRequest.php (NEW)
│   │   │   ├── ProductRequest.php (NEW)
│   │   │   ├── OrderStatusRequest.php (NEW)
│   │   │   ├── SettingsRequest.php (NEW)
├── Models/
│   ├── Vendor.php (NEW)
│   ├── VendorCommissionLog.php (NEW)
│   ├── VendorPayout.php (NEW)
│   ├── VendorReview.php (NEW)
├── Services/
│   ├── VendorService.php (NEW)
│   ├── CommissionService.php (NEW) - Handle earnings calculation
│   ├── PayoutService.php (NEW) - Handle payment to vendor
├── Filament/
│   ├── Resources/
│   │   ├── VendorResource.php (NEW)

resources/views/vendor/
├── layouts/
│   ├── app.blade.php (vendor layout)
├── dashboard.blade.php
├── products/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
├── orders/
│   ├── index.blade.php
│   ├── show.blade.php
├── profile.blade.php
├── settings.blade.php
├── analytics.blade.php
├── reviews/
│   ├── index.blade.php
├── earnings/
│   ├── index.blade.php
├── notifications.blade.php
├── auth/
│   ├── register.blade.php

routes/
├── vendor.php (NEW - vendor routes)
├── web.php (UPDATE - add vendor routes)
```

---

## 🛣️ ROUTES STRUCTURE

```php
// routes/vendor.php (NEW FILE)
Route::middleware(['auth', 'vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');
    
    // Products
    Route::resource('products', VendorProductController::class)->except(['show']);
    Route::patch('products/{product}/toggle-status', [VendorProductController::class, 'toggleStatus'])->name('products.toggle-status');
    
    // Orders
    Route::get('orders', [VendorOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{transaction}', [VendorOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{transaction}/status', [VendorOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::post('orders/{transaction}/send-invoice', [VendorOrderController::class, 'sendInvoice'])->name('orders.send-invoice');
    Route::post('orders/{transaction}/notes', [VendorOrderController::class, 'addNotes'])->name('orders.add-notes');
    
    // Profile & Settings
    Route::get('profile', [VendorSettingsController::class, 'profile'])->name('profile');
    Route::get('settings', [VendorSettingsController::class, 'edit'])->name('settings.edit');
    Route::patch('settings', [VendorSettingsController::class, 'update'])->name('settings.update');
    
    // Analytics
    Route::get('analytics', [VendorAnalyticsController::class, 'index'])->name('analytics');
    Route::get('analytics/export', [VendorAnalyticsController::class, 'export'])->name('analytics.export');
    
    // Reviews
    Route::get('reviews', [VendorReviewController::class, 'index'])->name('reviews.index');
    Route::patch('reviews/{review}/toggle-hide', [VendorReviewController::class, 'toggleHide'])->name('reviews.toggle-hide');
    Route::post('reviews/{review}/reply', [VendorReviewController::class, 'reply'])->name('reviews.reply');
    
    // Earnings
    Route::get('earnings', [VendorEarningsController::class, 'index'])->name('earnings.index');
    Route::post('earnings/request-payout', [VendorEarningsController::class, 'requestPayout'])->name('earnings.request-payout');
    
    // Notifications
    Route::get('notifications', [VendorNotificationController::class, 'index'])->name('notifications.index');
    Route::patch('notifications/{notification}/read', [VendorNotificationController::class, 'markRead'])->name('notifications.read');
    Route::delete('notifications/{notification}', [VendorNotificationController::class, 'destroy'])->name('notifications.destroy');
});

// Routes to add to routes/web.php
Route::get('/vendor/register', [VendorRegistrationController::class, 'create'])->name('vendor.register');
Route::post('/vendor/register', [VendorRegistrationController::class, 'store']);
Route::get('/vendor/{vendor}', [VendorProfileController::class, 'show'])->name('vendor.public-profile');
```

---

## 🔐 AUTHORIZATION & MIDDLEWARE

**New Middleware:**
- `IsVendor.php` - Check if user role is vendor
- `VendorOwner.php` - Check if vendor owns the product/order

**Authorization Rules:**
- Only vendors can access `/vendor/*` routes
- Vendor can only see/edit own products
- Vendor can only see/manage own orders
- Vendor can only see own earnings
- Admin can manage all vendors

**Gates/Policies:**
```php
// In AuthServiceProvider or AppServiceProvider
Gate::define('view-vendor-dashboard', function(User $user) {
    return $user->role === 'vendor' && $user->vendor->is_approved;
});

Gate::define('create-product', function(User $user) {
    return $user->role === 'vendor';
});

Gate::define('update-product', function(User $user, Product $product) {
    return $user->id === $product->vendor->user_id;
});
```

---

## 📦 DEPENDENCIES

```bash
# Already in composer.json:
- laravel/filament

# May need to add:
composer require maatwebsite/excel  # For export functionality
composer require spatie/laravel-medialibrary  # For image management (optional)
```

---

## 🎨 UI/UX GUIDELINES

- **Vendor Dashboard:** Professional, metric-focused, similar to Shopify
- **Product Management:** Simple form, image preview, bulk actions
- **Order Management:** Clear status flow, timeline view
- **Analytics:** Charts readable, insights actionable
- **Mobile:** Responsive, vendor can manage shop on phone
- **Colors:**
  - Primary: Blue (professional)
  - Success: Green (completed orders)
  - Warning: Orange (pending orders)
  - Danger: Red (suspended/cancelled)

---

## ✅ ACCEPTANCE CRITERIA

### Vendor Registration
- [ ] Registration form validates all fields
- [ ] User created with vendor role
- [ ] Vendor profile created
- [ ] Email verification sent
- [ ] Redirect to dashboard
- [ ] Admin receives vendor approval notification
- [ ] New vendor status shows as pending_approval

### Vendor Dashboard
- [ ] All widgets display correct data
- [ ] Charts render properly
- [ ] Recent orders populated
- [ ] Quick stats accurate
- [ ] All CTA buttons work
- [ ] Mobile responsive

### Product Management
- [ ] Can create/edit/delete products
- [ ] Image upload works
- [ ] SKU validation works (unique per vendor)
- [ ] All filters work
- [ ] Bulk actions work
- [ ] Draft/published toggle works
- [ ] SEO fields saved correctly

### Order Management
- [ ] Can view all own orders
- [ ] Can view order details
- [ ] Can update order status
- [ ] Status update triggers notification
- [ ] Can send invoice
- [ ] Can add vendor notes
- [ ] Can contact customer
- [ ] Order filtering works

### Analytics
- [ ] Charts display correctly
- [ ] Date range filter works
- [ ] All metrics calculated correctly
- [ ] Export to Excel works
- [ ] Export to PDF works

### Earnings & Commission
- [ ] Commission calculated correctly
- [ ] Earnings displayed accurately
- [ ] Payment history shows
- [ ] Can request payout
- [ ] Payout status tracked

### Reviews
- [ ] Can see all reviews
- [ ] Can hide/unhide reviews
- [ ] Can reply to reviews
- [ ] Average rating calculated
- [ ] Review sorting/filtering works

### Filament Admin Panel
- [ ] Can view all vendors
- [ ] Can approve/reject vendors
- [ ] Can suspend vendors
- [ ] Can edit vendor info
- [ ] Can manage commission
- [ ] Can view earnings

---

## 🔄 VENDOR STATUS FLOW

```
Registration → Pending Approval (Admin review)
            → Approved (Can start selling)
            → Suspended (Payment issue, policy violation, etc)
            → Deactivated (Vendor request)
            → Deleted (Admin action)
```

---

## 📧 NOTIFICATIONS TO IMPLEMENT

1. **Order received** - When customer makes booking
2. **Payment received** - When payment successful
3. **New review** - When customer leaves review
4. **Review reply mention** - When someone replies to vendor's review reply
5. **Stock alert** - When product out of stock
6. **Payout processed** - When vendor payment sent
7. **Admin message** - From admin to vendor
8. **Approval status** - When vendor approved/rejected

---

## 💰 COMMISSION CALCULATION

**Formula:**
```
Commission = Transaction Total × (Commission Rate / 100)
Vendor Earnings = Transaction Total - Commission
```

**Example:**
- Transaction: 1,000,000 IDR
- Commission Rate: 15%
- Commission: 150,000 IDR
- Vendor Earnings: 850,000 IDR

**Payment Terms:**
- Minimum payout: 100,000 IDR
- Payout frequency: Weekly/Monthly (configurable)
- Payout method: Bank transfer

---

## 🧪 TESTING CHECKLIST

**Manual Testing:**
- [ ] Complete vendor registration flow
- [ ] Approve vendor in admin panel
- [ ] Access vendor dashboard
- [ ] Create new product
- [ ] Edit product
- [ ] Delete product
- [ ] Receive order & manage it
- [ ] View and reply to reviews
- [ ] Check earnings calculation
- [ ] Request payout
- [ ] Mobile responsiveness

**Unit Tests:**
- [ ] Commission calculation
- [ ] Authorization gates
- [ ] Product query (only own products)
- [ ] Order query (only own orders)

**Integration Tests:**
- [ ] Vendor registration email
- [ ] Admin approval notification
- [ ] Order notification to vendor
- [ ] Payout processing

---

## 📝 IMPORTANT NOTES

1. **Vendor Approval Flow:**
   - New vendor automatically pending_approval
   - Admin must manually approve
   - Vendor can't sell until approved
   - Send notification when approved

2. **Commission:**
   - Set globally in config or per vendor
   - Calculate at transaction completion
   - Track in commission_logs for audit
   - Pay out weekly/monthly

3. **Product Visibility:**
   - Only show vendor's own products on dashboard
   - Public can see all products (including vendor info)
   - Vendor can't see other vendors' sales data

4. **Order Management:**
   - Vendor can update order status
   - Status flow: Pending → Ready → Completed → Closed
   - Vendor can't accept/reject order (auto-accept when paid)
   - Can cancel if not started

5. **Security:**
   - Verify vendor owns product before edit/delete
   - Verify vendor owns order before viewing
   - Validate all file uploads
   - Sanitize vendor input

6. **Performance:**
   - Use eager loading (with, includes)
   - Add indexes on vendor_id
   - Cache dashboard stats
   - Paginate tables properly

---

## 🚀 IMPLEMENTATION TIMELINE

**Day 1:**
- Database migrations
- Vendor model & relationships
- Vendor registration (controller, form, validation)
- Admin approval flow
- Vendor dashboard (basic)

**Day 2:**
- Product management (CRUD)
- Order management (list & detail)
- Vendor settings
- Commission calculation service
- Earnings page

**Day 3:**
- Analytics page
- Reviews management
- Filament admin panel
- Notifications
- Testing & refinement

---

## 🎯 SUCCESS CRITERIA

✅ Vendor can register → Get approved → Manage products → Receive orders → Get paid  
✅ Admin can manage vendors (approve, suspend, etc)  
✅ Commission calculated accurately  
✅ All metrics & analytics working  
✅ Mobile responsive  
✅ Notification system functional  

---

**This is a complete, production-ready vendor system specification ready for implementation.**
