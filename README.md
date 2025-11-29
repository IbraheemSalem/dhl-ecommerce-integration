# DHL eCommerce Integration for Laravel

Package: `ibraheem/dhl-ecommerce-integration`

A complete DHL eCommerce Solutions REST API integration for Laravel, supporting:

- Multi-merchant accounts
- Create shipments
- Rates API
- Tracking
- Cancel shipment
- PDF/PNG labels
- Webhooks (with signature verification)
- Admin panel (Blade UI)
- Logging system
- Events + Jobs
- DTOs, Services, HTTP client, testing suite

---

## Installation

```bash
composer require ibraheem/dhl-ecommerce-integration
```

Publish config & assets:

```bash
php artisan vendor:publish --tag=dhl-config
php artisan vendor:publish --tag=dhl-assets
```

Run migrations:

```bash
php artisan migrate
```

---

## Environment Variables

```
DHL_ECOMMERCE_BASE_URL=https://api.dhl.com/ecommerce
DHL_ECOMMERCE_CLIENT_ID=your_client_id
DHL_ECOMMERCE_CLIENT_SECRET=your_secret
DHL_ECOMMERCE_ACCOUNT=your_account
DHL_WEBHOOK_SECRET=your_webhook_secret
```

---

## Using the Package

### Create a Shipment

```php
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\AddressDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\CreateShipmentDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\ShipmentItemDTO;
use Ibraheem\DhlEcommerceIntegration\Services\DhlShipmentService;

$dto = new CreateShipmentDTO(
    shipper: new AddressDTO('Store ABC', '123 King Rd', 'Riyadh', 'Riyadh', '12345', 'SA', '0555555555'),
    recipient: new AddressDTO('Customer', '55 Queen St', 'Dubai', 'Dubai', '00000', 'AE', '0554444444'),
    items: [new ShipmentItemDTO('Shoes', 1, 0.7)],
    serviceType: 'EXPRESS',
    reference: 'ORDER-1001'
);

$shipment = app(DhlShipmentService::class)->create($dto);
```

### Get Rates

```php
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\RateRequestDTO;
use Ibraheem\DhlEcommerceIntegration\Services\DhlRateService;

$rates = app(DhlRateService::class)->getRates(
    new RateRequestDTO($origin, $destination, 1.5)
);
```

### Track Shipment

```php
use Ibraheem\DhlEcommerceIntegration\Services\DhlTrackingService;

$track = app(DhlTrackingService::class)->track('TRACK12345');
```

### Download Label

```php
use Ibraheem\DhlEcommerceIntegration\Services\DhlLabelService;

$pdf = app(DhlLabelService::class)->get('TRACK12345');
Storage::put('labels/TRACK12345.pdf', $pdf);
```

---

## Webhooks

Webhook endpoint:

```
POST /dhl/webhook
```

DHL will send:

- shipment_created
- in_transit
- delivered
- cancelled

Listen to events:

```php
use Ibraheem\DhlEcommerceIntegration\Events\DhlWebhookEvent;

Event::listen(DhlWebhookEvent::class, function ($event) {
    Log::info('Webhook received', $event->payload);
});
```

---

## Admin Panel

Visit `/dhl-admin` to access:

- Settings
- Merchant management
- Logs viewer

---

## Tests

```bash
php artisan test
```

---

## API Documentation

For complete REST API documentation, see **[API.md](API.md)**

## Usage Guide

For complete usage guide, see **[USAGE.md](USAGE.md)**

## License

MIT
