# Usage Guide

## Resolving Services

Use dependency injection to resolve services from the container:

```php
use Ibraheem\DhlEcommerceIntegration\Services\DhlShipmentService;

public function store(DhlShipmentService $service)
{
    // ...
}
```

## Creating Shipments

```php
$dto = new CreateShipmentDTO($shipper, $recipient, $items, 'EXPRESS');
$service->create($dto);
```

## Fetching Rates

```php
$rates = $rateService->getRates(new RateRequestDTO($origin, $destination, 2.5));
```

## Tracking Shipments

```php
$status = $tracking->track('TRACK123');
```
