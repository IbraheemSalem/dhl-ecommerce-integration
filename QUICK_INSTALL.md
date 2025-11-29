# ⚡ تثبيت سريع - DHL eCommerce Integration

## 📦 التثبيت في 4 خطوات

### 1️⃣ تثبيت الحزمة

```bash
composer require ibraheem/dhl-ecommerce-integration
```

### 2️⃣ نشر الملفات

```bash
php artisan vendor:publish --tag=dhl-config
php artisan vendor:publish --tag=dhl-assets
```

### 3️⃣ تشغيل Migrations

```bash
php artisan migrate
```

### 4️⃣ إعداد .env

أضف إلى ملف `.env`:

```env
DHL_ECOMMERCE_BASE_URL=https://api.dhl.com/ecommerce
DHL_ECOMMERCE_CLIENT_ID=your_client_id
DHL_ECOMMERCE_CLIENT_SECRET=your_secret
DHL_ECOMMERCE_ACCOUNT=your_account
DHL_WEBHOOK_SECRET=your_webhook_secret
```

---

## ✅ تم! الحزمة جاهزة للاستخدام

### استخدام سريع:

```php
use Ibraheem\DhlEcommerceIntegration\Services\DhlShipmentService;

$shipment = app(DhlShipmentService::class)->create($dto);
```

### الوصول للوحة التحكم:

```
http://your-domain.com/dhl-admin
```

---

## 📚 للمزيد من التفاصيل

- **دليل التثبيت الكامل (عربي)**: `INSTALLATION.md`
- **Installation Guide (English)**: `INSTALLATION_EN.md`
- **GitHub**: https://github.com/IbraheemSalem/dhl-ecommerce-integration
- **Packagist**: https://packagist.org/packages/ibraheem/dhl-ecommerce-integration

---

**Package**: `ibraheem/dhl-ecommerce-integration`  
**Version**: 1.0.0  
**License**: MIT

