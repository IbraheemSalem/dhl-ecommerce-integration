# 📦 دليل تثبيت حزمة DHL eCommerce Integration

## 🚀 التثبيت السريع

### الخطوة 1: تثبيت الحزمة عبر Composer

```bash
composer require ibraheem/dhl-ecommerce-integration
```

### الخطوة 2: نشر ملفات الإعدادات والأصول

```bash
# نشر ملف الإعدادات
php artisan vendor:publish --tag=dhl-config

# نشر ملفات الأصول (CSS/JS)
php artisan vendor:publish --tag=dhl-assets
```

### الخطوة 3: تشغيل Migrations

```bash
php artisan migrate
```

### الخطوة 4: إعداد متغيرات البيئة

أضف المتغيرات التالية إلى ملف `.env`:

```env
# DHL eCommerce API Configuration
DHL_ECOMMERCE_BASE_URL=https://api.dhl.com/ecommerce
DHL_ECOMMERCE_CLIENT_ID=your_client_id_here
DHL_ECOMMERCE_CLIENT_SECRET=your_client_secret_here
DHL_ECOMMERCE_ACCOUNT=your_account_number_here
DHL_WEBHOOK_SECRET=your_webhook_secret_here
```

---

## 📋 المتطلبات

### متطلبات النظام

- **PHP**: >= 8.1
- **Laravel**: ^10.0 | ^11.0
- **Composer**: 2.0 أو أحدث

### الحزم المطلوبة (يتم تثبيتها تلقائياً)

- `guzzlehttp/guzzle`: ^7.8
- `illuminate/support`: ^10.0|^11.0
- `illuminate/http`: ^10.0|^11.0
- `illuminate/cache`: ^10.0|^11.0
- `illuminate/events`: ^10.0|^11.0

---

## ⚙️ الإعداد التفصيلي

### 1. تثبيت الحزمة

```bash
composer require ibraheem/dhl-ecommerce-integration
```

بعد التثبيت، سيتم اكتشاف الحزمة تلقائياً من قبل Laravel (Auto-discovery).

### 2. نشر ملفات الإعدادات

```bash
php artisan vendor:publish --tag=dhl-config
```

سيتم إنشاء ملف `config/dhl.php` في مجلد `config` الخاص بمشروعك.

### 3. نشر ملفات الأصول

```bash
php artisan vendor:publish --tag=dhl-assets
```

سيتم نسخ ملفات CSS و JavaScript إلى `public/vendor/dhl/`.

### 4. تشغيل Migrations

```bash
php artisan migrate
```

سيتم إنشاء الجداول التالية:
- `dhl_merchants` - لحسابات التجار
- `dhl_logs` - لتسجيل طلبات API

### 5. إعداد API Routes (اختياري)

إذا أردت استخدام الحزمة من خلال REST API، أنشئ Controller و Routes:

**أنشئ Controller:**
```bash
php artisan make:controller Api/DhlController
```

ثم أضف الكود من ملف **[API.md](API.md)** في قسم "إعداد API Routes".

**أضف Routes في `routes/api.php`:**
```php
use App\Http\Controllers\Api\DhlController;
use Illuminate\Support\Facades\Route;

Route::prefix('dhl')->name('dhl.')->group(function () {
    Route::post('/shipments', [DhlController::class, 'createShipment']);
    Route::post('/rates', [DhlController::class, 'getRates']);
    Route::get('/track/{trackingNumber}', [DhlController::class, 'track']);
    Route::post('/shipments/{shipmentId}/cancel', [DhlController::class, 'cancelShipment']);
    Route::get('/labels/{trackingNumber}', [DhlController::class, 'getLabel']);
});
```

**📚 للمزيد من التفاصيل:** راجع ملف **[API.md](API.md)**

### 6. إعداد متغيرات البيئة

افتح ملف `.env` وأضف:

```env
# DHL eCommerce API Base URL
DHL_ECOMMERCE_BASE_URL=https://api.dhl.com/ecommerce

# DHL API Credentials
DHL_ECOMMERCE_CLIENT_ID=your_client_id
DHL_ECOMMERCE_CLIENT_SECRET=your_client_secret
DHL_ECOMMERCE_ACCOUNT=your_account_number

# Webhook Secret (للتأكد من صحة Webhooks)
DHL_WEBHOOK_SECRET=your_webhook_secret
```

**ملاحظة:** احصل على هذه القيم من حساب DHL eCommerce الخاص بك.

---

## 🔧 الإعدادات المتقدمة

### تخصيص ملف الإعدادات

بعد نشر ملف الإعدادات، يمكنك تعديل `config/dhl.php`:

```php
return [
    'base_url' => env('DHL_ECOMMERCE_BASE_URL', 'https://api.dhl.com/ecommerce'),
    
    'default_merchant' => env('DHL_DEFAULT_MERCHANT_ID', null),
    
    'cache' => [
        'token_ttl' => 3600, // مدة صلاحية Token بالثواني
    ],
    
    'logging' => [
        'enabled' => env('DHL_LOGGING_ENABLED', true),
        'level' => env('DHL_LOG_LEVEL', 'info'),
    ],
    
    // ... المزيد من الإعدادات
];
```

---

## ✅ التحقق من التثبيت

### 1. التحقق من وجود الحزمة

```bash
composer show ibraheem/dhl-ecommerce-integration
```

### 2. التحقق من Routes

```bash
php artisan route:list | grep dhl
```

يجب أن ترى Routes مثل:
- `GET /dhl-admin` - لوحة التحكم
- `POST /dhl/webhook` - Webhook endpoint

### 3. التحقق من Config

```bash
php artisan config:show dhl
```

### 4. اختبار بسيط

أنشئ ملف اختبار بسيط:

```php
// routes/web.php أو routes/api.php
Route::get('/test-dhl', function () {
    try {
        $service = app(\Ibraheem\DhlEcommerceIntegration\Services\DhlShipmentService::class);
        return response()->json(['status' => 'success', 'message' => 'DHL service loaded successfully']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
});
```

---

## 🎯 الاستخدام الأساسي

### إنشاء Shipment

```php
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\AddressDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\CreateShipmentDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\ShipmentItemDTO;
use Ibraheem\DhlEcommerceIntegration\Services\DhlShipmentService;

$dto = new CreateShipmentDTO(
    shipper: new AddressDTO(
        name: 'Store ABC',
        street: '123 King Rd',
        city: 'Riyadh',
        state: 'Riyadh',
        postalCode: '12345',
        countryCode: 'SA',
        phone: '0555555555'
    ),
    recipient: new AddressDTO(
        name: 'Customer Name',
        street: '55 Queen St',
        city: 'Dubai',
        state: 'Dubai',
        postalCode: '00000',
        countryCode: 'AE',
        phone: '0554444444'
    ),
    items: [
        new ShipmentItemDTO(
            description: 'Shoes',
            quantity: 1,
            weight: 0.7
        )
    ],
    serviceType: 'EXPRESS',
    reference: 'ORDER-1001'
);

$shipment = app(DhlShipmentService::class)->create($dto);
```

### الحصول على الأسعار

```php
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\RateRequestDTO;
use Ibraheem\DhlEcommerceIntegration\Services\DhlRateService;

$rateRequest = new RateRequestDTO(
    origin: 'SA',
    destination: 'AE',
    weight: 1.5
);

$rates = app(DhlRateService::class)->getRates($rateRequest);
```

### تتبع الشحنة

```php
use Ibraheem\DhlEcommerceIntegration\Services\DhlTrackingService;

$tracking = app(DhlTrackingService::class)->track('TRACK12345');
```

### تحميل Label

```php
use Ibraheem\DhlEcommerceIntegration\Services\DhlLabelService;
use Illuminate\Support\Facades\Storage;

$labelService = app(DhlLabelService::class);
$pdf = $labelService->get('TRACK12345');

Storage::put('labels/TRACK12345.pdf', $pdf);
```

---

## 🌐 الوصول إلى لوحة التحكم

بعد التثبيت، يمكنك الوصول إلى لوحة التحكم الإدارية:

```
http://your-domain.com/dhl-admin
```

لوحة التحكم توفر:
- إدارة حسابات التجار
- عرض السجلات (Logs)
- الإعدادات
- إحصائيات

---

## 🔔 إعداد Webhooks

### 1. إضافة Route للـ Webhook

الحزمة تضيف Route تلقائياً:
```
POST /dhl/webhook
```

### 2. إعداد Webhook في DHL Dashboard

1. اذهب إلى DHL eCommerce Dashboard
2. اذهب إلى Webhooks Settings
3. أضف URL:
   ```
   https://your-domain.com/dhl/webhook
   ```
4. حدّث `DHL_WEBHOOK_SECRET` في `.env`

### 3. الاستماع للأحداث

```php
use Ibraheem\DhlEcommerceIntegration\Events\DhlWebhookEvent;
use Illuminate\Support\Facades\Event;

Event::listen(DhlWebhookEvent::class, function ($event) {
    Log::info('DHL Webhook received', [
        'type' => $event->type,
        'payload' => $event->payload
    ]);
    
    // معالجة الحدث حسب النوع
    switch ($event->type) {
        case 'shipment_created':
            // معالجة إنشاء الشحنة
            break;
        case 'in_transit':
            // معالجة الشحنة في الطريق
            break;
        case 'delivered':
            // معالجة تسليم الشحنة
            break;
        case 'cancelled':
            // معالجة إلغاء الشحنة
            break;
    }
});
```

---

## 🧪 الاختبارات

### تشغيل الاختبارات

```bash
# من مجلد المشروع الرئيسي
php artisan test

# أو من مجلد الحزمة
cd vendor/ibraheem/dhl-ecommerce-integration
composer test
```

---

## 🐛 حل المشاكل الشائعة

### المشكلة: الحزمة غير موجودة

**الحل:**
```bash
composer clear-cache
composer require ibraheem/dhl-ecommerce-integration
```

### المشكلة: Routes غير موجودة

**الحل:**
```bash
php artisan route:clear
php artisan config:clear
php artisan cache:clear
```

### المشكلة: Service Provider غير محمّل

**الحل:**
تأكد من أن Laravel يكتشف الحزمة تلقائياً. إذا لم يحدث ذلك، أضف في `config/app.php`:

```php
'providers' => [
    // ...
    Ibraheem\DhlEcommerceIntegration\Providers\DhlServiceProvider::class,
],
```

### المشكلة: Migration فشل

**الحل:**
```bash
php artisan migrate:status
php artisan migrate --path=vendor/ibraheem/dhl-ecommerce-integration/database/migrations
```

---

## 📚 المزيد من المعلومات

- **GitHub**: https://github.com/IbraheemSalem/dhl-ecommerce-integration
- **Packagist**: https://packagist.org/packages/ibraheem/dhl-ecommerce-integration
- **API Documentation**: راجع ملف **[API.md](API.md)** لدليل API الكامل
- **Usage Guide**: راجع ملف **[USAGE.md](USAGE.md)** لدليل الاستخدام الكامل
- **Documentation**: راجع مجلد `docs/` في الحزمة

---

## 📝 ملاحظات مهمة

1. **API Credentials**: تأكد من الحصول على بيانات اعتماد صحيحة من DHL
2. **Webhook Secret**: استخدم secret قوي وآمن
3. **Environment**: استخدم قيم مختلفة للـ Development و Production
4. **Logging**: فعّل Logging في Development للمساعدة في Debugging

---

## ✅ Checklist التثبيت

- [ ] تم تثبيت الحزمة عبر Composer
- [ ] تم نشر ملفات الإعدادات
- [ ] تم نشر ملفات الأصول
- [ ] تم تشغيل Migrations
- [ ] تم إضافة متغيرات البيئة في `.env`
- [ ] تم التحقق من Routes
- [ ] تم اختبار Service بسيط
- [ ] تم إعداد API Routes (اختياري - راجع [API.md](API.md))
- [ ] تم إعداد Webhook (إذا لزم الأمر)

---

**تم إنشاء هذا الدليل:** 2025-01-29  
**آخر تحديث:** 2025-01-29

