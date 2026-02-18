# Admin Panel Setup Guide

## ✅ ADMIN PANEL ACCESS

**URL**: http://127.0.0.1:8002/admin
**Login**: admin@chamakchemical.com / password

---

## ⚠️ PHP INTL EXTENSION REQUIRED

To fix the "intl extension required" error:

### **Option 1: Enable intl Extension (Recommended)**

1. Open `C:\xampp\php\php.ini`
2. Find line: `;extension=intl`
3. Remove semicolon: `extension=intl`
4. Save file
5. Restart Apache/Server

### **Option 2: Temporary Workaround**

The admin panel works but some number formatting features are limited without intl.

---

## 📊 ADMIN PANEL FEATURES

### **Dashboard** (http://127.0.0.1:8002/admin)
- Overview of system
- Quick stats
- Recent activity

### **Products** (http://127.0.0.1:8002/admin/products)
- View all products
- Add/Edit/Delete
- Manage pricing (retail + wholesale)
- Upload images
- Set translations (EN/UR)
- Stock management

### **Categories** (http://127.0.0.1:8002/admin/categories)
- View all categories
- Add/Edit/Delete
- Manage translations
- SEO settings

### **Orders** (http://127.0.0.1:8002/admin/orders)
- View all orders (retail + wholesale)
- Change order status (triggers WhatsApp)
- View order details
- Track payment status
- Search and filter

### **Dealers** (http://127.0.0.1:8002/admin/dealers)
- View dealer registrations
- **Approve/Reject dealers**
- Set dealer tier (Bronze/Silver/Gold/Platinum)
- Set credit limits
- View dealer orders

### **Users** (http://127.0.0.1:8002/admin/users)
- View all users
- Add/Edit/Delete
- Assign roles
- Activate/Deactivate

### **Site Settings** (http://127.0.0.1:8002/admin/site-settings)
- Configure checkout settings
- Set shipping costs
- WhatsApp configuration
- Payment methods
- General settings

---

## 🎯 COMMON ADMIN TASKS

### **Approve a Dealer:**
1. Go to Dealers
2. Click on pending dealer
3. Change "Approval Status" to "approved"
4. Set "Dealer Tier" (Bronze/Silver/Gold/Platinum)
5. Set credit limit
6. Save

### **Change Order Status:**
1. Go to Orders
2. Click on order
3. Change "Status" dropdown
4. Save
5. Customer gets WhatsApp notification automatically

### **Add New Product:**
1. Go to Products
2. Click "New Product"
3. Fill basic info (SKU, name, category)
4. Add translations (English & Urdu tabs)
5. Set pricing (retail + wholesale tiers)
6. Upload images
7. Set stock quantity
8. Save

### **Manage Site Settings:**
1. Go to Site Settings
2. Find setting key (e.g., "require_login_for_checkout")
3. Edit value
4. Save
5. Changes apply immediately

---

## 🎨 CUSTOMIZATION

### **Change Admin Colors:**
Edit `app/Providers/Filament/AdminPanelProvider.php`
Colors are already set to blue/orange matching your website.

### **Add More Widgets:**
```bash
php artisan make:filament-widget WidgetName
```

### **Customize Resources:**
Edit files in `app/Filament/Resources/`

---

## 📱 ADMIN PANEL WORKS ON

- ✅ Desktop
- ✅ Tablet
- ✅ Mobile (responsive)

---

**Your admin panel is fully functional! Enable intl extension for perfect number formatting.** 🚀
