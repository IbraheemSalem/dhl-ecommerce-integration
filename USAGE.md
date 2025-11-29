# 📚 دليل الاستخدام الكامل - DHL eCommerce Integration

## 📋 المحتويات

1. [نظرة عامة](#نظرة-عامة)
2. [استخدام API (REST API)](#استخدام-api-rest-api) ⭐ جديد
3. [إنشاء الشحنات](#إنشاء-الشحنات)
4. [الحصول على الأسعار](#الحصول-على-الأسعار)
5. [تتبع الشحنات](#تتبع-الشحنات)
6. [إلغاء الشحنة](#إلغاء-الشحنة)
7. [تحميل Labels](#تحميل-labels)
8. [Webhooks](#webhooks)
9. [Multi-Merchant Support](#multi-merchant-support)
10. [لوحة التحكم الإدارية](#لوحة-التحكم-الإدارية)
11. [معالجة الأخطاء](#معالجة-الأخطاء)
12. [أمثلة متقدمة](#أمثلة-متقدمة)

---

## نظرة عامة

حزمة DHL eCommerce Integration توفر واجهة كاملة للتعامل مع DHL eCommerce Solutions REST API. الحزمة تدعم:

- ✅ إنشاء الشحنات
- ✅ الحصول على الأسعار
- ✅ تتبع الشحنات
- ✅ إلغاء الشحنات
- ✅ تحميل Labels (PDF/PNG)
- ✅ Webhooks مع التحقق من التوقيع
- ✅ دعم Multi-Merchant
- ✅ لوحة تحكم إدارية
- ✅ نظام Logging شامل
- ✅ Events و Jobs

---

## استخدام API (REST API) ⭐

### نظرة عامة

يمكنك استخدام الحزمة من خلال REST API endpoints بدلاً من استخدام الكود مباشرة. هذا مفيد عندما تريد:
- إنشاء API للتطبيقات الخارجية
- استخدام الحزمة من Frontend (React, Vue, etc.)
- دمج الحزمة مع أنظمة أخرى

### إعداد API Routes

راجع ملف **[API.md](API.md)** للحصول على:
- ✅ دليل كامل لإنشاء API endpoints
- ✅ أمثلة Controllers جاهزة
- ✅ Request/Response Examples
- ✅ Postman Collection
- ✅ أمثلة cURL, JavaScript, PHP

### مثال سريع: استخدام API

#### إنشاء شحنة عبر API

```bash
curl -X POST http://your-domain.com/api/dhl/shipments \
  -H "Content-Type: application/json" \
  -d '{
    "shipper": {
      "name": "Store ABC",
      "street": "123 King Road",
      "city": "Riyadh",
      "state": "Riyadh",
      "postal_code": "12345",
      "country_code": "SA"
    },
    "recipient": {
      "name": "Customer",
      "street": "55 Queen Street",
      "city": "Dubai",
      "state": "Dubai",
      "postal_code": "00000",
      "country_code": "AE"
    },
    "items": [
      {
        "description": "Shoes",
        "quantity": 1,
        "weight": 0.7
      }
    ],
    "service_type": "EXPRESS",
    "reference": "ORDER-1001"
  }'
```

#### الحصول على الأسعار عبر API

```bash
curl -X POST http://your-domain.com/api/dhl/rates \
  -H "Content-Type: application/json" \
  -d '{
    "origin": {
      "postal_code": "12345",
      "country_code": "SA"
    },
    "destination": {
      "postal_code": "00000",
      "country_code": "AE"
    },
    "weight": 1.5
  }'
```

#### تتبع شحنة عبر API

```bash
curl -X GET http://your-domain.com/api/dhl/track/TRACK123456789
```

### API Endpoints المتاحة

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/dhl/shipments` | إنشاء شحنة جديدة |
| POST | `/api/dhl/rates` | الحصول على الأسعار |
| GET | `/api/dhl/track/{trackingNumber}` | تتبع شحنة |
| POST | `/api/dhl/shipments/{shipmentId}/cancel` | إلغاء شحنة |
| GET | `/api/dhl/labels/{trackingNumber}` | تحميل Label |

**📚 للمزيد من التفاصيل:** راجع ملف **[API.md](API.md)**

---

## إنشاء الشحنات

### الطريقة الأساسية

```php
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\AddressDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\CreateShipmentDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\ShipmentItemDTO;
use Ibraheem\DhlEcommerceIntegration\Services\DhlShipmentService;

// إنشاء عنوان المرسل
$shipper = new AddressDTO(
    name: 'Store ABC',
    street: '123 King Road',
    city: 'Riyadh',
    state: 'Riyadh',
    postalCode: '12345',
    countryCode: 'SA',
    phone: '0555555555',
    email: 'store@example.com'
);

// إنشاء عنوان المستلم
$recipient = new AddressDTO(
    name: 'Customer Name',
    street: '55 Queen Street',
    city: 'Dubai',
    state: 'Dubai',
    postalCode: '00000',
    countryCode: 'AE',
    phone: '0554444444',
    email: 'customer@example.com'
);

// إنشاء عناصر الشحنة
$items = [
    new ShipmentItemDTO(
        description: 'Running Shoes',
        quantity: 1,
        weight: 0.7, // بالكيلوجرام
        value: 150.00, // قيمة العنصر (اختياري)
        hsCode: '6404.11' // HS Code (اختياري)
    ),
    new ShipmentItemDTO(
        description: 'T-Shirt',
        quantity: 2,
        weight: 0.3,
        value: 50.00
    )
];

// إنشاء DTO للشحنة
$shipmentDTO = new CreateShipmentDTO(
    shipper: $shipper,
    recipient: $recipient,
    items: $items,
    serviceType: 'EXPRESS', // أو 'STANDARD'
    reference: 'ORDER-1001', // رقم مرجعي للطلب
    declaredValue: 200.00, // القيمة المعلنة (اختياري)
    currency: 'USD' // العملة (افتراضي: USD)
);

// إنشاء الشحنة
$shipmentService = app(DhlShipmentService::class);
$shipment = $shipmentService->create($shipmentDTO);

// النتيجة
/*
[
    'shipment_id' => '1234567890',
    'tracking_number' => 'TRACK123456789',
    'label_url' => 'https://...',
    'status' => 'created',
    'estimated_delivery' => '2025-01-30',
    ...
]
*/
```

### استخدام DhlClient (الطريقة الموصى بها)

```php
use Ibraheem\DhlEcommerceIntegration\Contracts\DhlClientInterface;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\CreateShipmentDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\AddressDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\ShipmentItemDTO;

$dhlClient = app(DhlClientInterface::class);

$dto = new CreateShipmentDTO(
    shipper: new AddressDTO('Store', '123 St', 'Riyadh', 'Riyadh', '12345', 'SA', '0555555555'),
    recipient: new AddressDTO('Customer', '55 St', 'Dubai', 'Dubai', '00000', 'AE', '0554444444'),
    items: [new ShipmentItemDTO('Product', 1, 0.5)],
    serviceType: 'EXPRESS',
    reference: 'ORDER-1001'
);

$shipment = $dhlClient->createShipment($dto);
```

### مثال في Controller

```php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Ibraheem\DhlEcommerceIntegration\Services\DhlShipmentService;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\CreateShipmentDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\AddressDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\ShipmentItemDTO;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function create(Request $request, DhlShipmentService $shipmentService)
    {
        $request->validate([
            'shipper.name' => 'required|string',
            'shipper.street' => 'required|string',
            'shipper.city' => 'required|string',
            'shipper.postal_code' => 'required|string',
            'shipper.country_code' => 'required|string|size:2',
            'recipient.name' => 'required|string',
            'recipient.street' => 'required|string',
            'recipient.city' => 'required|string',
            'recipient.postal_code' => 'required|string',
            'recipient.country_code' => 'required|string|size:2',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.weight' => 'required|numeric|min:0.1',
            'service_type' => 'required|in:EXPRESS,STANDARD',
        ]);

        try {
            $shipper = new AddressDTO(
                name: $request->input('shipper.name'),
                street: $request->input('shipper.street'),
                city: $request->input('shipper.city'),
                state: $request->input('shipper.state', ''),
                postalCode: $request->input('shipper.postal_code'),
                countryCode: $request->input('shipper.country_code'),
                phone: $request->input('shipper.phone'),
                email: $request->input('shipper.email')
            );

            $recipient = new AddressDTO(
                name: $request->input('recipient.name'),
                street: $request->input('recipient.street'),
                city: $request->input('recipient.city'),
                state: $request->input('recipient.state', ''),
                postalCode: $request->input('recipient.postal_code'),
                countryCode: $request->input('recipient.country_code'),
                phone: $request->input('recipient.phone'),
                email: $request->input('recipient.email')
            );

            $items = collect($request->input('items'))->map(function ($item) {
                return new ShipmentItemDTO(
                    description: $item['description'],
                    quantity: $item['quantity'],
                    weight: $item['weight'],
                    value: $item['value'] ?? null,
                    hsCode: $item['hs_code'] ?? null
                );
            })->toArray();

            $dto = new CreateShipmentDTO(
                shipper: $shipper,
                recipient: $recipient,
                items: $items,
                serviceType: $request->input('service_type'),
                reference: $request->input('reference'),
                declaredValue: $request->input('declared_value'),
                currency: $request->input('currency', 'USD')
            );

            $shipment = $shipmentService->create($dto);

            return response()->json([
                'success' => true,
                'data' => $shipment
            ], 201);

        } catch (\Ibraheem\DhlEcommerceIntegration\Domain\Exceptions\DhlApiException $e) {
            return response()->json([
                'success' => false,
                'message' => 'DHL API Error: ' . $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
```

### أنواع الخدمات المتاحة

```php
// EXPRESS - خدمة سريعة
$dto = new CreateShipmentDTO(..., serviceType: 'EXPRESS', ...);

// STANDARD - خدمة عادية
$dto = new CreateShipmentDTO(..., serviceType: 'STANDARD', ...);
```

---

## الحصول على الأسعار

### الطريقة الأساسية

```php
use Ibraheem\DhlEcommerceIntegration\Services\DhlRateService;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\RateRequestDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\AddressDTO;

// عنوان المنشأ
$origin = new AddressDTO(
    name: 'Store',
    street: '123 King Road',
    city: 'Riyadh',
    state: 'Riyadh',
    postalCode: '12345',
    countryCode: 'SA'
);

// عنوان الوجهة
$destination = new AddressDTO(
    name: 'Customer',
    street: '55 Queen Street',
    city: 'Dubai',
    state: 'Dubai',
    postalCode: '00000',
    countryCode: 'AE'
);

// إنشاء طلب الأسعار
$rateRequest = new RateRequestDTO(
    origin: $origin,
    destination: $destination,
    weight: 1.5, // الوزن بالكيلوجرام
    serviceType: 'EXPRESS', // اختياري: 'EXPRESS' أو 'STANDARD'
    declaredValue: 200.00, // اختياري: القيمة المعلنة
    currency: 'USD' // اختياري: العملة (افتراضي: USD)
);

// الحصول على الأسعار
$rateService = app(DhlRateService::class);
$rates = $rateService->getRates($rateRequest);

// النتيجة
/*
[
    'rates' => [
        [
            'service_type' => 'EXPRESS',
            'price' => 45.50,
            'currency' => 'USD',
            'estimated_delivery' => '2025-01-30',
            'transit_time' => '1-2 days'
        ],
        [
            'service_type' => 'STANDARD',
            'price' => 25.00,
            'currency' => 'USD',
            'estimated_delivery' => '2025-02-02',
            'transit_time' => '3-5 days'
        ]
    ],
    'origin' => 'SA',
    'destination' => 'AE',
    'weight' => 1.5
]
*/
```

### استخدام DhlClient

```php
use Ibraheem\DhlEcommerceIntegration\Contracts\DhlClientInterface;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\RateRequestDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\AddressDTO;

$dhlClient = app(DhlClientInterface::class);

$rateRequest = new RateRequestDTO(
    origin: new AddressDTO('Store', '123 St', 'Riyadh', 'Riyadh', '12345', 'SA'),
    destination: new AddressDTO('Customer', '55 St', 'Dubai', 'Dubai', '00000', 'AE'),
    weight: 1.5
);

$rates = $dhlClient->getRates($rateRequest);
```

### مثال في Controller

```php
use App\Http\Controllers\Controller;
use Ibraheem\DhlEcommerceIntegration\Services\DhlRateService;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\RateRequestDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\AddressDTO;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function getRates(Request $request, DhlRateService $rateService)
    {
        $request->validate([
            'origin.country_code' => 'required|string|size:2',
            'origin.postal_code' => 'required|string',
            'destination.country_code' => 'required|string|size:2',
            'destination.postal_code' => 'required|string',
            'weight' => 'required|numeric|min:0.1',
            'service_type' => 'nullable|in:EXPRESS,STANDARD',
            'declared_value' => 'nullable|numeric|min:0',
        ]);

        try {
            $origin = new AddressDTO(
                name: $request->input('origin.name', 'Origin'),
                street: $request->input('origin.street', ''),
                city: $request->input('origin.city', ''),
                state: $request->input('origin.state', ''),
                postalCode: $request->input('origin.postal_code'),
                countryCode: $request->input('origin.country_code')
            );

            $destination = new AddressDTO(
                name: $request->input('destination.name', 'Destination'),
                street: $request->input('destination.street', ''),
                city: $request->input('destination.city', ''),
                state: $request->input('destination.state', ''),
                postalCode: $request->input('destination.postal_code'),
                countryCode: $request->input('destination.country_code')
            );

            $rateRequest = new RateRequestDTO(
                origin: $origin,
                destination: $destination,
                weight: $request->input('weight'),
                serviceType: $request->input('service_type'),
                declaredValue: $request->input('declared_value'),
                currency: $request->input('currency', 'USD')
            );

            $rates = $rateService->getRates($rateRequest);

            return response()->json([
                'success' => true,
                'data' => $rates
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
```

---

## تتبع الشحنات

### الطريقة الأساسية

```php
use Ibraheem\DhlEcommerceIntegration\Services\DhlTrackingService;

$trackingService = app(DhlTrackingService::class);
$tracking = $trackingService->track('TRACK123456789');

// النتيجة
/*
[
    'tracking_number' => 'TRACK123456789',
    'status' => 'in_transit',
    'current_location' => 'Dubai Hub',
    'events' => [
        [
            'timestamp' => '2025-01-29 10:00:00',
            'location' => 'Riyadh Hub',
            'description' => 'Shipment picked up',
            'status' => 'picked_up'
        ],
        [
            'timestamp' => '2025-01-29 15:30:00',
            'location' => 'Dubai Hub',
            'description' => 'In transit',
            'status' => 'in_transit'
        ]
    ],
    'estimated_delivery' => '2025-01-30',
    'delivery_address' => '...'
]
*/
```

### استخدام DhlClient

```php
use Ibraheem\DhlEcommerceIntegration\Contracts\DhlClientInterface;

$dhlClient = app(DhlClientInterface::class);
$tracking = $dhlClient->track('TRACK123456789');
```

### مثال في Controller

```php
use App\Http\Controllers\Controller;
use Ibraheem\DhlEcommerceIntegration\Services\DhlTrackingService;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function track(Request $request, DhlTrackingService $trackingService)
    {
        $request->validate([
            'tracking_number' => 'required|string'
        ]);

        try {
            $tracking = $trackingService->track($request->input('tracking_number'));

            return response()->json([
                'success' => true,
                'data' => $tracking
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }
}
```

### حالات الشحنة المتاحة

```php
// حالات الشحنة المحتملة:
'created'      // تم إنشاء الشحنة
'picked_up'    // تم استلام الشحنة
'in_transit'   // في الطريق
'out_for_delivery' // جاهزة للتسليم
'delivered'    // تم التسليم
'cancelled'    // تم الإلغاء
'exception'    // حدث خطأ
```

---

## إلغاء الشحنة

### الطريقة الأساسية

```php
use Ibraheem\DhlEcommerceIntegration\Services\DhlShipmentService;

$shipmentService = app(DhlShipmentService::class);
$result = $shipmentService->cancel('SHIPMENT123456789');

// النتيجة
/*
[
    'shipment_id' => 'SHIPMENT123456789',
    'status' => 'cancelled',
    'cancelled_at' => '2025-01-29 12:00:00',
    'message' => 'Shipment cancelled successfully'
]
*/
```

### استخدام DhlClient

```php
use Ibraheem\DhlEcommerceIntegration\Contracts\DhlClientInterface;

$dhlClient = app(DhlClientInterface::class);
$result = $dhlClient->cancel('SHIPMENT123456789');
```

### مثال في Controller

```php
use App\Http\Controllers\Controller;
use Ibraheem\DhlEcommerceIntegration\Services\DhlShipmentService;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function cancel(Request $request, DhlShipmentService $shipmentService)
    {
        $request->validate([
            'shipment_id' => 'required|string'
        ]);

        try {
            $result = $shipmentService->cancel($request->input('shipment_id'));

            return response()->json([
                'success' => true,
                'data' => $result
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
```

---

## تحميل Labels

### تحميل Label بصيغة PDF

```php
use Ibraheem\DhlEcommerceIntegration\Services\DhlLabelService;
use Illuminate\Support\Facades\Storage;

$labelService = app(DhlLabelService::class);

// تحميل Label بصيغة PDF
$pdfContent = $labelService->get('TRACK123456789', 'pdf');

// حفظ الملف
Storage::put('labels/TRACK123456789.pdf', $pdfContent);

// أو إرجاعه كـ Response
return response($pdfContent, 200)
    ->header('Content-Type', 'application/pdf')
    ->header('Content-Disposition', 'attachment; filename="label.pdf"');
```

### تحميل Label بصيغة PNG

```php
use Ibraheem\DhlEcommerceIntegration\Services\DhlLabelService;

$labelService = app(DhlLabelService::class);

// تحميل Label بصيغة PNG
$pngContent = $labelService->get('TRACK123456789', 'png');

// حفظ الملف
Storage::put('labels/TRACK123456789.png', $pngContent);

// أو إرجاعه كـ Response
return response($pngContent, 200)
    ->header('Content-Type', 'image/png')
    ->header('Content-Disposition', 'attachment; filename="label.png"');
```

### استخدام DhlClient

```php
use Ibraheem\DhlEcommerceIntegration\Contracts\DhlClientInterface;
use Illuminate\Support\Facades\Storage;

$dhlClient = app(DhlClientInterface::class);

// PDF (افتراضي)
$pdf = $dhlClient->getLabel('TRACK123456789', 'pdf');
Storage::put('labels/TRACK123456789.pdf', $pdf);

// PNG
$png = $dhlClient->getLabel('TRACK123456789', 'png');
Storage::put('labels/TRACK123456789.png', $png);
```

### مثال في Controller

```php
use App\Http\Controllers\Controller;
use Ibraheem\DhlEcommerceIntegration\Services\DhlLabelService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LabelController extends Controller
{
    public function download(Request $request, DhlLabelService $labelService)
    {
        $request->validate([
            'tracking_number' => 'required|string',
            'format' => 'nullable|in:pdf,png'
        ]);

        try {
            $format = $request->input('format', 'pdf');
            $trackingNumber = $request->input('tracking_number');
            
            $labelContent = $labelService->get($trackingNumber, $format);

            $contentType = $format === 'png' ? 'image/png' : 'application/pdf';
            $filename = "label_{$trackingNumber}.{$format}";

            return response($labelContent, 200)
                ->header('Content-Type', $contentType)
                ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }
}
```

---

## Webhooks

### إعداد Webhook

1. **في DHL Dashboard:**
   - اذهب إلى Webhooks Settings
   - أضف URL: `https://your-domain.com/dhl/webhook`
   - احفظ Webhook Secret

2. **في ملف `.env`:**
   ```env
   DHL_WEBHOOK_SECRET=your_webhook_secret_here
   ```

### Webhook Endpoint

الحزمة تضيف Route تلقائياً:
```
POST /dhl/webhook
```

### الاستماع للأحداث

```php
use Ibraheem\DhlEcommerceIntegration\Events\DhlWebhookEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

// في AppServiceProvider أو EventServiceProvider
Event::listen(DhlWebhookEvent::class, function (DhlWebhookEvent $event) {
    $payload = $event->payload;
    $type = $payload['type'] ?? 'unknown';

    Log::info('DHL Webhook received', [
        'type' => $type,
        'payload' => $payload
    ]);

    // معالجة الحدث حسب النوع
    switch ($type) {
        case 'shipment_created':
            $this->handleShipmentCreated($payload);
            break;

        case 'in_transit':
            $this->handleInTransit($payload);
            break;

        case 'delivered':
            $this->handleDelivered($payload);
            break;

        case 'cancelled':
            $this->handleCancelled($payload);
            break;
    }
});
```

### معالجة أحداث محددة

```php
// في EventServiceProvider
use Ibraheem\DhlEcommerceIntegration\Events\DhlWebhookEvent;
use App\Listeners\HandleShipmentCreated;
use App\Listeners\HandleShipmentDelivered;

protected $listen = [
    DhlWebhookEvent::class => [
        HandleShipmentCreated::class,
        HandleShipmentDelivered::class,
    ],
];
```

### إنشاء Listener

```php
namespace App\Listeners;

use Ibraheem\DhlEcommerceIntegration\Events\DhlWebhookEvent;
use Illuminate\Support\Facades\Log;

class HandleShipmentCreated
{
    public function handle(DhlWebhookEvent $event)
    {
        $payload = $event->payload;

        if (($payload['type'] ?? '') === 'shipment_created') {
            $shipmentId = $payload['shipment_id'] ?? null;
            $trackingNumber = $payload['tracking_number'] ?? null;

            Log::info('Shipment created via webhook', [
                'shipment_id' => $shipmentId,
                'tracking_number' => $trackingNumber
            ]);

            // تحديث قاعدة البيانات
            // إرسال إشعار
            // إلخ...
        }
    }
}
```

### أنواع Webhooks المتاحة

```php
'shipment_created'  // تم إنشاء شحنة جديدة
'in_transit'        // الشحنة في الطريق
'delivered'         // تم التسليم
'cancelled'         // تم الإلغاء
'exception'         // حدث خطأ
```

---

## Multi-Merchant Support

### إضافة حساب تاجر جديد

```php
use Ibraheem\DhlEcommerceIntegration\Domain\Entities\Merchant;

$merchant = Merchant::create([
    'name' => 'Store ABC',
    'client_id' => 'merchant_client_id',
    'client_secret' => 'merchant_client_secret',
    'account_number' => 'merchant_account',
    'is_active' => true,
    'settings' => [
        'default_service_type' => 'EXPRESS',
        'auto_track' => true,
    ]
]);
```

### استخدام حساب تاجر محدد

```php
use Ibraheem\DhlEcommerceIntegration\Domain\Entities\Merchant;
use Ibraheem\DhlEcommerceIntegration\Services\DhlShipmentService;

$merchant = Merchant::find(1);

// تعيين Merchant للخدمة
$shipmentService = app(DhlShipmentService::class);
// (يحتاج إلى تعديل Service لدعم Multi-Merchant)
```

---

## لوحة التحكم الإدارية

### الوصول إلى اللوحة

```
http://your-domain.com/dhl-admin
```

### الميزات المتاحة

1. **إدارة التجار**
   - عرض جميع الحسابات
   - إضافة حساب جديد
   - تعديل حساب موجود
   - تفعيل/تعطيل حساب

2. **عرض السجلات (Logs)**
   - سجلات API Requests
   - سجلات Webhooks
   - سجلات الأخطاء

3. **الإعدادات**
   - إعدادات عامة
   - إعدادات API
   - إعدادات Webhook

---

## معالجة الأخطاء

### أنواع الأخطاء

```php
use Ibraheem\DhlEcommerceIntegration\Domain\Exceptions\DhlException;
use Ibraheem\DhlEcommerceIntegration\Domain\Exceptions\DhlApiException;

try {
    $shipment = $shipmentService->create($dto);
} catch (DhlApiException $e) {
    // خطأ من DHL API
    Log::error('DHL API Error', [
        'message' => $e->getMessage(),
        'code' => $e->getCode()
    ]);
    
    return response()->json([
        'success' => false,
        'message' => 'DHL API Error: ' . $e->getMessage()
    ], 400);
    
} catch (DhlException $e) {
    // خطأ عام في الحزمة
    Log::error('DHL Package Error', [
        'message' => $e->getMessage()
    ]);
    
    return response()->json([
        'success' => false,
        'message' => 'DHL Error: ' . $e->getMessage()
    ], 500);
    
} catch (\Exception $e) {
    // خطأ عام
    Log::error('General Error', [
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
    
    return response()->json([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ], 500);
}
```

### التحقق من صحة البيانات

```php
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\AddressDTO;

try {
    $address = new AddressDTO(
        name: 'Test',
        street: '123 St',
        city: 'Riyadh',
        state: 'Riyadh',
        postalCode: '12345',
        countryCode: 'SA'
    );
} catch (\TypeError $e) {
    // خطأ في نوع البيانات
    return response()->json([
        'success' => false,
        'message' => 'Invalid data type'
    ], 400);
}
```

---

## أمثلة متقدمة

### مثال كامل: إنشاء شحنة مع معالجة كاملة

```php
namespace App\Services;

use Ibraheem\DhlEcommerceIntegration\Services\DhlShipmentService;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\CreateShipmentDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\AddressDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\ShipmentItemDTO;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OrderShippingService
{
    public function __construct(
        private DhlShipmentService $shipmentService
    ) {}

    public function createShipmentForOrder($order)
    {
        DB::beginTransaction();
        
        try {
            // إعداد بيانات المرسل
            $shipper = new AddressDTO(
                name: config('app.name'),
                street: $order->store->address,
                city: $order->store->city,
                state: $order->store->state,
                postalCode: $order->store->postal_code,
                countryCode: $order->store->country_code,
                phone: $order->store->phone,
                email: $order->store->email
            );

            // إعداد بيانات المستلم
            $recipient = new AddressDTO(
                name: $order->customer->name,
                street: $order->shipping_address,
                city: $order->shipping_city,
                state: $order->shipping_state,
                postalCode: $order->shipping_postal_code,
                countryCode: $order->shipping_country_code,
                phone: $order->customer->phone,
                email: $order->customer->email
            );

            // إعداد عناصر الشحنة
            $items = $order->items->map(function ($item) {
                return new ShipmentItemDTO(
                    description: $item->product->name,
                    quantity: $item->quantity,
                    weight: $item->product->weight,
                    value: $item->price,
                    hsCode: $item->product->hs_code
                );
            })->toArray();

            // إنشاء DTO
            $dto = new CreateShipmentDTO(
                shipper: $shipper,
                recipient: $recipient,
                items: $items,
                serviceType: $order->shipping_method === 'express' ? 'EXPRESS' : 'STANDARD',
                reference: "ORDER-{$order->id}",
                declaredValue: $order->total,
                currency: $order->currency
            );

            // إنشاء الشحنة
            $shipment = $this->shipmentService->create($dto);

            // حفظ معلومات الشحنة في قاعدة البيانات
            $order->update([
                'tracking_number' => $shipment['tracking_number'],
                'shipment_id' => $shipment['shipment_id'],
                'shipping_status' => 'created'
            ]);

            DB::commit();

            Log::info('Shipment created successfully', [
                'order_id' => $order->id,
                'tracking_number' => $shipment['tracking_number']
            ]);

            return $shipment;

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Failed to create shipment', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }
}
```

### مثال: تتبع متعدد الشحنات

```php
use Ibraheem\DhlEcommerceIntegration\Services\DhlTrackingService;
use Illuminate\Support\Collection;

class BulkTrackingService
{
    public function __construct(
        private DhlTrackingService $trackingService
    ) {}

    public function trackMultiple(array $trackingNumbers): Collection
    {
        $results = collect($trackingNumbers)->map(function ($trackingNumber) {
            try {
                $tracking = $this->trackingService->track($trackingNumber);
                return [
                    'tracking_number' => $trackingNumber,
                    'success' => true,
                    'data' => $tracking
                ];
            } catch (\Exception $e) {
                return [
                    'tracking_number' => $trackingNumber,
                    'success' => false,
                    'error' => $e->getMessage()
                ];
            }
        });

        return $results;
    }
}
```

### مثال: استخدام Queue Jobs

```php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Ibraheem\DhlEcommerceIntegration\Services\DhlShipmentService;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\CreateShipmentDTO;

class CreateShipmentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private CreateShipmentDTO $dto,
        private int $orderId
    ) {}

    public function handle(DhlShipmentService $shipmentService)
    {
        try {
            $shipment = $shipmentService->create($this->dto);

            // تحديث الطلب
            \App\Models\Order::find($this->orderId)->update([
                'tracking_number' => $shipment['tracking_number'],
                'shipment_id' => $shipment['shipment_id']
            ]);

            // إرسال إشعار
            // ...

        } catch (\Exception $e) {
            \Log::error('Failed to create shipment in queue', [
                'order_id' => $this->orderId,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }
}

// الاستخدام
CreateShipmentJob::dispatch($dto, $orderId);
```

---

## نصائح وأفضل الممارسات

### 1. استخدام Dependency Injection

```php
// ✅ جيد
public function __construct(
    private DhlShipmentService $shipmentService
) {}

// ❌ سيء
$shipmentService = app(DhlShipmentService::class);
```

### 2. معالجة الأخطاء بشكل صحيح

```php
// ✅ جيد
try {
    $shipment = $shipmentService->create($dto);
} catch (DhlApiException $e) {
    // معالجة خطأ API
} catch (\Exception $e) {
    // معالجة خطأ عام
}

// ❌ سيء
$shipment = $shipmentService->create($dto); // بدون معالجة أخطاء
```

### 3. استخدام Transactions

```php
// ✅ جيد
DB::beginTransaction();
try {
    $shipment = $shipmentService->create($dto);
    $order->update(['tracking_number' => $shipment['tracking_number']]);
    DB::commit();
} catch (\Exception $e) {
    DB::rollBack();
    throw $e;
}
```

### 4. Logging

```php
// ✅ جيد
Log::info('Creating shipment', ['order_id' => $orderId]);
try {
    $shipment = $shipmentService->create($dto);
    Log::info('Shipment created', ['tracking_number' => $shipment['tracking_number']]);
} catch (\Exception $e) {
    Log::error('Failed to create shipment', ['error' => $e->getMessage()]);
    throw $e;
}
```

### 5. Validation

```php
// ✅ جيد
$request->validate([
    'shipper.country_code' => 'required|string|size:2',
    'recipient.country_code' => 'required|string|size:2',
    'items' => 'required|array|min:1',
    'items.*.weight' => 'required|numeric|min:0.1',
]);
```

---

## روابط مفيدة

- **GitHub**: https://github.com/IbraheemSalem/dhl-ecommerce-integration
- **Packagist**: https://packagist.org/packages/ibraheem/dhl-ecommerce-integration
- **Documentation**: راجع مجلد `docs/` في الحزمة
- **Installation Guide**: `INSTALLATION.md`

---

## الدعم

إذا واجهت أي مشاكل أو لديك أسئلة:

1. راجع هذا الدليل
2. راجع ملفات التوثيق في مجلد `docs/`
3. افتح Issue على GitHub

---

**تم إنشاء هذا الدليل:** 2025-01-29  
**آخر تحديث:** 2025-01-29

