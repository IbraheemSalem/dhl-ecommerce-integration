# 🌐 دليل API الكامل - DHL eCommerce Integration

## 📋 المحتويات

1. [نظرة عامة](#نظرة-عامة)
2. [إعداد API Routes](#إعداد-api-routes)
3. [Authentication](#authentication)
4. [API Endpoints](#api-endpoints)
5. [Request/Response Examples](#requestresponse-examples)
6. [Error Handling](#error-handling)
7. [Postman Collection](#postman-collection)
8. [Testing API](#testing-api)

---

## نظرة عامة

هذا الدليل يشرح كيفية إنشاء REST API كاملة لاستخدام حزمة DHL eCommerce Integration. يمكنك إنشاء API endpoints تسمح للتطبيقات الخارجية بالتفاعل مع DHL من خلال تطبيقك.

---

## إعداد API Routes

### 1. إنشاء API Controller

أنشئ ملف `app/Http/Controllers/Api/DhlController.php`:

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Ibraheem\DhlEcommerceIntegration\Services\DhlShipmentService;
use Ibraheem\DhlEcommerceIntegration\Services\DhlRateService;
use Ibraheem\DhlEcommerceIntegration\Services\DhlTrackingService;
use Ibraheem\DhlEcommerceIntegration\Services\DhlLabelService;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\CreateShipmentDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\AddressDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\ShipmentItemDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\RateRequestDTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DhlController extends Controller
{
    public function __construct(
        private DhlShipmentService $shipmentService,
        private DhlRateService $rateService,
        private DhlTrackingService $trackingService,
        private DhlLabelService $labelService
    ) {}

    /**
     * إنشاء شحنة جديدة
     * POST /api/dhl/shipments
     */
    public function createShipment(Request $request)
    {
        $request->validate([
            'shipper.name' => 'required|string|max:255',
            'shipper.street' => 'required|string|max:255',
            'shipper.city' => 'required|string|max:100',
            'shipper.state' => 'nullable|string|max:100',
            'shipper.postal_code' => 'required|string|max:20',
            'shipper.country_code' => 'required|string|size:2',
            'shipper.phone' => 'nullable|string|max:20',
            'shipper.email' => 'nullable|email|max:255',
            'recipient.name' => 'required|string|max:255',
            'recipient.street' => 'required|string|max:255',
            'recipient.city' => 'required|string|max:100',
            'recipient.state' => 'nullable|string|max:100',
            'recipient.postal_code' => 'required|string|max:20',
            'recipient.country_code' => 'required|string|size:2',
            'recipient.phone' => 'nullable|string|max:20',
            'recipient.email' => 'nullable|email|max:255',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.weight' => 'required|numeric|min:0.1',
            'items.*.value' => 'nullable|numeric|min:0',
            'items.*.hs_code' => 'nullable|string|max:20',
            'service_type' => 'required|in:EXPRESS,STANDARD',
            'reference' => 'nullable|string|max:100',
            'declared_value' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|size:3',
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

            $shipment = $this->shipmentService->create($dto);

            return response()->json([
                'success' => true,
                'message' => 'Shipment created successfully',
                'data' => $shipment
            ], 201);

        } catch (\Ibraheem\DhlEcommerceIntegration\Domain\Exceptions\DhlApiException $e) {
            Log::error('DHL API Error', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'DHL API Error: ' . $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            Log::error('Shipment Creation Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error creating shipment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * الحصول على الأسعار
     * POST /api/dhl/rates
     */
    public function getRates(Request $request)
    {
        $request->validate([
            'origin.name' => 'nullable|string|max:255',
            'origin.street' => 'nullable|string|max:255',
            'origin.city' => 'nullable|string|max:100',
            'origin.state' => 'nullable|string|max:100',
            'origin.postal_code' => 'required|string|max:20',
            'origin.country_code' => 'required|string|size:2',
            'destination.name' => 'nullable|string|max:255',
            'destination.street' => 'nullable|string|max:255',
            'destination.city' => 'nullable|string|max:100',
            'destination.state' => 'nullable|string|max:100',
            'destination.postal_code' => 'required|string|max:20',
            'destination.country_code' => 'required|string|size:2',
            'weight' => 'required|numeric|min:0.1',
            'service_type' => 'nullable|in:EXPRESS,STANDARD',
            'declared_value' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|size:3',
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

            $rates = $this->rateService->getRates($rateRequest);

            return response()->json([
                'success' => true,
                'data' => $rates
            ]);

        } catch (\Exception $e) {
            Log::error('Get Rates Error', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error getting rates: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * تتبع شحنة
     * GET /api/dhl/track/{trackingNumber}
     */
    public function track(Request $request, string $trackingNumber)
    {
        try {
            $tracking = $this->trackingService->track($trackingNumber);

            return response()->json([
                'success' => true,
                'data' => $tracking
            ]);

        } catch (\Ibraheem\DhlEcommerceIntegration\Domain\Exceptions\DhlApiException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tracking not found: ' . $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            Log::error('Tracking Error', [
                'tracking_number' => $trackingNumber,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error tracking shipment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * إلغاء شحنة
     * POST /api/dhl/shipments/{shipmentId}/cancel
     */
    public function cancelShipment(Request $request, string $shipmentId)
    {
        try {
            $result = $this->shipmentService->cancel($shipmentId);

            return response()->json([
                'success' => true,
                'message' => 'Shipment cancelled successfully',
                'data' => $result
            ]);

        } catch (\Exception $e) {
            Log::error('Cancel Shipment Error', [
                'shipment_id' => $shipmentId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error cancelling shipment: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * تحميل Label
     * GET /api/dhl/labels/{trackingNumber}
     */
    public function getLabel(Request $request, string $trackingNumber)
    {
        $request->validate([
            'format' => 'nullable|in:pdf,png'
        ]);

        try {
            $format = $request->input('format', 'pdf');
            $labelContent = $this->labelService->get($trackingNumber, $format);

            $contentType = $format === 'png' ? 'image/png' : 'application/pdf';
            $filename = "label_{$trackingNumber}.{$format}";

            return response($labelContent, 200)
                ->header('Content-Type', $contentType)
                ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");

        } catch (\Exception $e) {
            Log::error('Get Label Error', [
                'tracking_number' => $trackingNumber,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error getting label: ' . $e->getMessage()
            ], 404);
        }
    }
}
```

### 2. إضافة API Routes

أضف في `routes/api.php`:

```php
use App\Http\Controllers\Api\DhlController;
use Illuminate\Support\Facades\Route;

// DHL API Routes
Route::prefix('dhl')->name('dhl.')->group(function () {
    // إنشاء شحنة
    Route::post('/shipments', [DhlController::class, 'createShipment'])->name('shipments.create');
    
    // الحصول على الأسعار
    Route::post('/rates', [DhlController::class, 'getRates'])->name('rates.get');
    
    // تتبع شحنة
    Route::get('/track/{trackingNumber}', [DhlController::class, 'track'])->name('track');
    
    // إلغاء شحنة
    Route::post('/shipments/{shipmentId}/cancel', [DhlController::class, 'cancelShipment'])->name('shipments.cancel');
    
    // تحميل Label
    Route::get('/labels/{trackingNumber}', [DhlController::class, 'getLabel'])->name('labels.get');
});
```

### 3. إضافة Authentication (اختياري)

إذا أردت حماية API endpoints:

```php
Route::prefix('dhl')
    ->middleware(['auth:sanctum']) // أو أي middleware آخر
    ->name('dhl.')
    ->group(function () {
        // ... routes
    });
```

---

## API Endpoints

### Base URL

```
https://your-domain.com/api/dhl
```

### Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/shipments` | إنشاء شحنة جديدة |
| POST | `/rates` | الحصول على الأسعار |
| GET | `/track/{trackingNumber}` | تتبع شحنة |
| POST | `/shipments/{shipmentId}/cancel` | إلغاء شحنة |
| GET | `/labels/{trackingNumber}` | تحميل Label |

---

## Request/Response Examples

### 1. إنشاء شحنة

**Request:**
```http
POST /api/dhl/shipments
Content-Type: application/json
Authorization: Bearer {token}

{
  "shipper": {
    "name": "Store ABC",
    "street": "123 King Road",
    "city": "Riyadh",
    "state": "Riyadh",
    "postal_code": "12345",
    "country_code": "SA",
    "phone": "0555555555",
    "email": "store@example.com"
  },
  "recipient": {
    "name": "Customer Name",
    "street": "55 Queen Street",
    "city": "Dubai",
    "state": "Dubai",
    "postal_code": "00000",
    "country_code": "AE",
    "phone": "0554444444",
    "email": "customer@example.com"
  },
  "items": [
    {
      "description": "Running Shoes",
      "quantity": 1,
      "weight": 0.7,
      "value": 150.00,
      "hs_code": "6404.11"
    },
    {
      "description": "T-Shirt",
      "quantity": 2,
      "weight": 0.3,
      "value": 50.00
    }
  ],
  "service_type": "EXPRESS",
  "reference": "ORDER-1001",
  "declared_value": 200.00,
  "currency": "USD"
}
```

**Response (Success - 201):**
```json
{
  "success": true,
  "message": "Shipment created successfully",
  "data": {
    "shipment_id": "1234567890",
    "tracking_number": "TRACK123456789",
    "label_url": "https://...",
    "status": "created",
    "estimated_delivery": "2025-01-30",
    "service_type": "EXPRESS",
    "reference": "ORDER-1001"
  }
}
```

**Response (Error - 400):**
```json
{
  "success": false,
  "message": "DHL API Error: Invalid address"
}
```

### 2. الحصول على الأسعار

**Request:**
```http
POST /api/dhl/rates
Content-Type: application/json

{
  "origin": {
    "postal_code": "12345",
    "country_code": "SA"
  },
  "destination": {
    "postal_code": "00000",
    "country_code": "AE"
  },
  "weight": 1.5,
  "service_type": "EXPRESS",
  "declared_value": 200.00,
  "currency": "USD"
}
```

**Response (Success - 200):**
```json
{
  "success": true,
  "data": {
    "rates": [
      {
        "service_type": "EXPRESS",
        "price": 45.50,
        "currency": "USD",
        "estimated_delivery": "2025-01-30",
        "transit_time": "1-2 days"
      },
      {
        "service_type": "STANDARD",
        "price": 25.00,
        "currency": "USD",
        "estimated_delivery": "2025-02-02",
        "transit_time": "3-5 days"
      }
    ],
    "origin": "SA",
    "destination": "AE",
    "weight": 1.5
  }
}
```

### 3. تتبع شحنة

**Request:**
```http
GET /api/dhl/track/TRACK123456789
```

**Response (Success - 200):**
```json
{
  "success": true,
  "data": {
    "tracking_number": "TRACK123456789",
    "status": "in_transit",
    "current_location": "Dubai Hub",
    "events": [
      {
        "timestamp": "2025-01-29 10:00:00",
        "location": "Riyadh Hub",
        "description": "Shipment picked up",
        "status": "picked_up"
      },
      {
        "timestamp": "2025-01-29 15:30:00",
        "location": "Dubai Hub",
        "description": "In transit",
        "status": "in_transit"
      }
    ],
    "estimated_delivery": "2025-01-30",
    "delivery_address": "..."
  }
}
```

**Response (Not Found - 404):**
```json
{
  "success": false,
  "message": "Tracking not found: Invalid tracking number"
}
```

### 4. إلغاء شحنة

**Request:**
```http
POST /api/dhl/shipments/SHIPMENT123456789/cancel
```

**Response (Success - 200):**
```json
{
  "success": true,
  "message": "Shipment cancelled successfully",
  "data": {
    "shipment_id": "SHIPMENT123456789",
    "status": "cancelled",
    "cancelled_at": "2025-01-29 12:00:00",
    "message": "Shipment cancelled successfully"
  }
}
```

### 5. تحميل Label

**Request:**
```http
GET /api/dhl/labels/TRACK123456789?format=pdf
```

**Response (Success - 200):**
```
Content-Type: application/pdf
Content-Disposition: attachment; filename="label_TRACK123456789.pdf"

[PDF Binary Content]
```

---

## Error Handling

### Error Response Format

جميع الأخطاء تعيد نفس التنسيق:

```json
{
  "success": false,
  "message": "Error message here"
}
```

### HTTP Status Codes

| Code | Description |
|------|-------------|
| 200 | Success |
| 201 | Created |
| 400 | Bad Request (Validation Error / DHL API Error) |
| 401 | Unauthorized |
| 404 | Not Found |
| 500 | Internal Server Error |

### Validation Errors

```json
{
  "success": false,
  "message": "The given data was invalid.",
  "errors": {
    "shipper.name": [
      "The shipper.name field is required."
    ],
    "items": [
      "The items field is required."
    ]
  }
}
```

---

## Postman Collection

### Import Collection

```json
{
  "info": {
    "name": "DHL eCommerce Integration API",
    "schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
  },
  "item": [
    {
      "name": "Create Shipment",
      "request": {
        "method": "POST",
        "header": [
          {
            "key": "Content-Type",
            "value": "application/json"
          },
          {
            "key": "Authorization",
            "value": "Bearer {{token}}"
          }
        ],
        "body": {
          "mode": "raw",
          "raw": "{\n  \"shipper\": {\n    \"name\": \"Store ABC\",\n    \"street\": \"123 King Road\",\n    \"city\": \"Riyadh\",\n    \"state\": \"Riyadh\",\n    \"postal_code\": \"12345\",\n    \"country_code\": \"SA\",\n    \"phone\": \"0555555555\"\n  },\n  \"recipient\": {\n    \"name\": \"Customer\",\n    \"street\": \"55 Queen Street\",\n    \"city\": \"Dubai\",\n    \"state\": \"Dubai\",\n    \"postal_code\": \"00000\",\n    \"country_code\": \"AE\",\n    \"phone\": \"0554444444\"\n  },\n  \"items\": [\n    {\n      \"description\": \"Shoes\",\n      \"quantity\": 1,\n      \"weight\": 0.7\n    }\n  ],\n  \"service_type\": \"EXPRESS\",\n  \"reference\": \"ORDER-1001\"\n}"
        },
        "url": {
          "raw": "{{base_url}}/api/dhl/shipments",
          "host": ["{{base_url}}"],
          "path": ["api", "dhl", "shipments"]
        }
      }
    },
    {
      "name": "Get Rates",
      "request": {
        "method": "POST",
        "header": [
          {
            "key": "Content-Type",
            "value": "application/json"
          }
        ],
        "body": {
          "mode": "raw",
          "raw": "{\n  \"origin\": {\n    \"postal_code\": \"12345\",\n    \"country_code\": \"SA\"\n  },\n  \"destination\": {\n    \"postal_code\": \"00000\",\n    \"country_code\": \"AE\"\n  },\n  \"weight\": 1.5\n}"
        },
        "url": {
          "raw": "{{base_url}}/api/dhl/rates",
          "host": ["{{base_url}}"],
          "path": ["api", "dhl", "rates"]
        }
      }
    },
    {
      "name": "Track Shipment",
      "request": {
        "method": "GET",
        "header": [],
        "url": {
          "raw": "{{base_url}}/api/dhl/track/{{tracking_number}}",
          "host": ["{{base_url}}"],
          "path": ["api", "dhl", "track", "{{tracking_number}}"]
        }
      }
    },
    {
      "name": "Cancel Shipment",
      "request": {
        "method": "POST",
        "header": [
          {
            "key": "Authorization",
            "value": "Bearer {{token}}"
          }
        ],
        "url": {
          "raw": "{{base_url}}/api/dhl/shipments/{{shipment_id}}/cancel",
          "host": ["{{base_url}}"],
          "path": ["api", "dhl", "shipments", "{{shipment_id}}", "cancel"]
        }
      }
    },
    {
      "name": "Get Label",
      "request": {
        "method": "GET",
        "header": [],
        "url": {
          "raw": "{{base_url}}/api/dhl/labels/{{tracking_number}}?format=pdf",
          "host": ["{{base_url}}"],
          "path": ["api", "dhl", "labels", "{{tracking_number}}"],
          "query": [
            {
              "key": "format",
              "value": "pdf"
            }
          ]
        }
      }
    }
  ],
  "variable": [
    {
      "key": "base_url",
      "value": "http://localhost:8000"
    },
    {
      "key": "token",
      "value": ""
    },
    {
      "key": "tracking_number",
      "value": "TRACK123456789"
    },
    {
      "key": "shipment_id",
      "value": "SHIPMENT123456789"
    }
  ]
}
```

---

## Testing API

### باستخدام cURL

#### إنشاء شحنة

```bash
curl -X POST http://localhost:8000/api/dhl/shipments \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{
    "shipper": {
      "name": "Store ABC",
      "street": "123 King Road",
      "city": "Riyadh",
      "state": "Riyadh",
      "postal_code": "12345",
      "country_code": "SA",
      "phone": "0555555555"
    },
    "recipient": {
      "name": "Customer",
      "street": "55 Queen Street",
      "city": "Dubai",
      "state": "Dubai",
      "postal_code": "00000",
      "country_code": "AE",
      "phone": "0554444444"
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

#### الحصول على الأسعار

```bash
curl -X POST http://localhost:8000/api/dhl/rates \
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

#### تتبع شحنة

```bash
curl -X GET http://localhost:8000/api/dhl/track/TRACK123456789
```

#### إلغاء شحنة

```bash
curl -X POST http://localhost:8000/api/dhl/shipments/SHIPMENT123456789/cancel \
  -H "Authorization: Bearer YOUR_TOKEN"
```

#### تحميل Label

```bash
curl -X GET "http://localhost:8000/api/dhl/labels/TRACK123456789?format=pdf" \
  --output label.pdf
```

### باستخدام JavaScript (Fetch)

```javascript
// إنشاء شحنة
async function createShipment(data) {
  const response = await fetch('http://localhost:8000/api/dhl/shipments', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': 'Bearer YOUR_TOKEN'
    },
    body: JSON.stringify(data)
  });
  
  return await response.json();
}

// استخدام
const shipment = await createShipment({
  shipper: {
    name: 'Store ABC',
    street: '123 King Road',
    city: 'Riyadh',
    state: 'Riyadh',
    postal_code: '12345',
    country_code: 'SA'
  },
  recipient: {
    name: 'Customer',
    street: '55 Queen Street',
    city: 'Dubai',
    state: 'Dubai',
    postal_code: '00000',
    country_code: 'AE'
  },
  items: [
    {
      description: 'Shoes',
      quantity: 1,
      weight: 0.7
    }
  ],
  service_type: 'EXPRESS',
  reference: 'ORDER-1001'
});

console.log(shipment);
```

### باستخدام PHP (Guzzle)

```php
use GuzzleHttp\Client;

$client = new Client([
    'base_uri' => 'http://localhost:8000',
    'headers' => [
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer YOUR_TOKEN'
    ]
]);

// إنشاء شحنة
$response = $client->post('/api/dhl/shipments', [
    'json' => [
        'shipper' => [
            'name' => 'Store ABC',
            'street' => '123 King Road',
            'city' => 'Riyadh',
            'state' => 'Riyadh',
            'postal_code' => '12345',
            'country_code' => 'SA'
        ],
        'recipient' => [
            'name' => 'Customer',
            'street' => '55 Queen Street',
            'city' => 'Dubai',
            'state' => 'Dubai',
            'postal_code' => '00000',
            'country_code' => 'AE'
        ],
        'items' => [
            [
                'description' => 'Shoes',
                'quantity' => 1,
                'weight' => 0.7
            ]
        ],
        'service_type' => 'EXPRESS',
        'reference' => 'ORDER-1001'
    ]
]);

$result = json_decode($response->getBody(), true);
```

---

## Rate Limiting

يمكنك إضافة Rate Limiting لحماية API:

```php
Route::prefix('dhl')
    ->middleware(['throttle:60,1']) // 60 requests per minute
    ->name('dhl.')
    ->group(function () {
        // ... routes
    });
```

---

## CORS Configuration

إذا كنت تستخدم API من frontend، تأكد من إعداد CORS:

```php
// config/cors.php
return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:3000'],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
```

---

## Security Best Practices

1. **استخدم HTTPS** في Production
2. **فعّل Authentication** (Sanctum, Passport, etc.)
3. **استخدم Rate Limiting**
4. **تحقق من البيانات** (Validation)
5. **سجل جميع الطلبات** (Logging)
6. **استخدم API Keys** للوصول الخارجي

---

## روابط مفيدة

- **GitHub**: https://github.com/IbraheemSalem/dhl-ecommerce-integration
- **Packagist**: https://packagist.org/packages/ibraheem/dhl-ecommerce-integration
- **Documentation**: راجع `USAGE.md` و `INSTALLATION.md`

---

**تم إنشاء هذا الدليل:** 2025-01-29  
**آخر تحديث:** 2025-01-29

