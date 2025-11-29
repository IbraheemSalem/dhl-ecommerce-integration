# 📦 DHL eCommerce Integration - Installation Guide

## 🚀 Quick Installation

### Step 1: Install via Composer

```bash
composer require ibraheem/dhl-ecommerce-integration
```

### Step 2: Publish Configuration and Assets

```bash
# Publish configuration file
php artisan vendor:publish --tag=dhl-config

# Publish assets (CSS/JS)
php artisan vendor:publish --tag=dhl-assets
```

### Step 3: Run Migrations

```bash
php artisan migrate
```

### Step 4: Configure Environment Variables

Add the following variables to your `.env` file:

```env
# DHL eCommerce API Configuration
DHL_ECOMMERCE_BASE_URL=https://api.dhl.com/ecommerce
DHL_ECOMMERCE_CLIENT_ID=your_client_id_here
DHL_ECOMMERCE_CLIENT_SECRET=your_client_secret_here
DHL_ECOMMERCE_ACCOUNT=your_account_number_here
DHL_WEBHOOK_SECRET=your_webhook_secret_here
```

---

## 📋 Requirements

### System Requirements

- **PHP**: >= 8.1
- **Laravel**: ^10.0 | ^11.0
- **Composer**: 2.0 or higher

### Required Packages (Auto-installed)

- `guzzlehttp/guzzle`: ^7.8
- `illuminate/support`: ^10.0|^11.0
- `illuminate/http`: ^10.0|^11.0
- `illuminate/cache`: ^10.0|^11.0
- `illuminate/events`: ^10.0|^11.0

---

## ⚙️ Detailed Setup

### 1. Install the Package

```bash
composer require ibraheem/dhl-ecommerce-integration
```

After installation, the package will be auto-discovered by Laravel.

### 2. Publish Configuration

```bash
php artisan vendor:publish --tag=dhl-config
```

This will create `config/dhl.php` in your project's `config` directory.

### 3. Publish Assets

```bash
php artisan vendor:publish --tag=dhl-assets
```

This will copy CSS and JavaScript files to `public/vendor/dhl/`.

### 4. Run Migrations

```bash
php artisan migrate
```

This will create the following tables:
- `dhl_merchants` - For merchant accounts
- `dhl_logs` - For API request logging

### 5. Configure Environment Variables

Open your `.env` file and add:

```env
# DHL eCommerce API Base URL
DHL_ECOMMERCE_BASE_URL=https://api.dhl.com/ecommerce

# DHL API Credentials
DHL_ECOMMERCE_CLIENT_ID=your_client_id
DHL_ECOMMERCE_CLIENT_SECRET=your_client_secret
DHL_ECOMMERCE_ACCOUNT=your_account_number

# Webhook Secret (for webhook verification)
DHL_WEBHOOK_SECRET=your_webhook_secret
```

**Note:** Get these values from your DHL eCommerce account.

---

## 🔧 Advanced Configuration

### Customize Configuration File

After publishing the configuration, you can modify `config/dhl.php`:

```php
return [
    'base_url' => env('DHL_ECOMMERCE_BASE_URL', 'https://api.dhl.com/ecommerce'),
    
    'default_merchant' => env('DHL_DEFAULT_MERCHANT_ID', null),
    
    'cache' => [
        'token_ttl' => 3600, // Token TTL in seconds
    ],
    
    'logging' => [
        'enabled' => env('DHL_LOGGING_ENABLED', true),
        'level' => env('DHL_LOG_LEVEL', 'info'),
    ],
    
    // ... more configuration options
];
```

---

## ✅ Verify Installation

### 1. Check Package Installation

```bash
composer show ibraheem/dhl-ecommerce-integration
```

### 2. Check Routes

```bash
php artisan route:list | grep dhl
```

You should see routes like:
- `GET /dhl-admin` - Admin dashboard
- `POST /dhl/webhook` - Webhook endpoint

### 3. Check Configuration

```bash
php artisan config:show dhl
```

### 4. Simple Test

Create a simple test:

```php
// routes/web.php or routes/api.php
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

## 🎯 Basic Usage

### Create a Shipment

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

### Get Rates

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

### Track Shipment

```php
use Ibraheem\DhlEcommerceIntegration\Services\DhlTrackingService;

$tracking = app(DhlTrackingService::class)->track('TRACK12345');
```

### Download Label

```php
use Ibraheem\DhlEcommerceIntegration\Services\DhlLabelService;
use Illuminate\Support\Facades\Storage;

$labelService = app(DhlLabelService::class);
$pdf = $labelService->get('TRACK12345');

Storage::put('labels/TRACK12345.pdf', $pdf);
```

---

## 🌐 Access Admin Panel

After installation, you can access the admin panel:

```
http://your-domain.com/dhl-admin
```

The admin panel provides:
- Merchant account management
- Logs viewer
- Settings
- Statistics

---

## 🔔 Webhook Setup

### 1. Webhook Route

The package automatically adds the route:
```
POST /dhl/webhook
```

### 2. Configure Webhook in DHL Dashboard

1. Go to DHL eCommerce Dashboard
2. Navigate to Webhooks Settings
3. Add URL:
   ```
   https://your-domain.com/dhl/webhook
   ```
4. Update `DHL_WEBHOOK_SECRET` in `.env`

### 3. Listen to Events

```php
use Ibraheem\DhlEcommerceIntegration\Events\DhlWebhookEvent;
use Illuminate\Support\Facades\Event;

Event::listen(DhlWebhookEvent::class, function ($event) {
    Log::info('DHL Webhook received', [
        'type' => $event->type,
        'payload' => $event->payload
    ]);
    
    // Handle event based on type
    switch ($event->type) {
        case 'shipment_created':
            // Handle shipment creation
            break;
        case 'in_transit':
            // Handle shipment in transit
            break;
        case 'delivered':
            // Handle shipment delivery
            break;
        case 'cancelled':
            // Handle shipment cancellation
            break;
    }
});
```

---

## 🧪 Testing

### Run Tests

```bash
# From main project directory
php artisan test

# Or from package directory
cd vendor/ibraheem/dhl-ecommerce-integration
composer test
```

---

## 🐛 Troubleshooting

### Issue: Package Not Found

**Solution:**
```bash
composer clear-cache
composer require ibraheem/dhl-ecommerce-integration
```

### Issue: Routes Not Found

**Solution:**
```bash
php artisan route:clear
php artisan config:clear
php artisan cache:clear
```

### Issue: Service Provider Not Loaded

**Solution:**
Make sure Laravel auto-discovers the package. If not, add to `config/app.php`:

```php
'providers' => [
    // ...
    Ibraheem\DhlEcommerceIntegration\Providers\DhlServiceProvider::class,
],
```

### Issue: Migration Failed

**Solution:**
```bash
php artisan migrate:status
php artisan migrate --path=vendor/ibraheem/dhl-ecommerce-integration/database/migrations
```

---

## 📚 More Information

- **GitHub**: https://github.com/IbraheemSalem/dhl-ecommerce-integration
- **Packagist**: https://packagist.org/packages/ibraheem/dhl-ecommerce-integration
- **API Documentation**: See **[API.md](API.md)** for complete API guide
- **Usage Guide**: See **[USAGE.md](USAGE.md)** for complete usage guide
- **Documentation**: Check the `docs/` folder in the package

---

## 📝 Important Notes

1. **API Credentials**: Make sure you have valid credentials from DHL
2. **Webhook Secret**: Use a strong and secure secret
3. **Environment**: Use different values for Development and Production
4. **Logging**: Enable logging in Development for debugging

---

## ✅ Installation Checklist

- [ ] Package installed via Composer
- [ ] Configuration files published
- [ ] Assets published
- [ ] Migrations run
- [ ] Environment variables added to `.env`
- [ ] Routes verified
- [ ] Simple service test passed
- [ ] Webhook configured (if needed)

---

**Created:** 2025-01-29  
**Last Updated:** 2025-01-29

