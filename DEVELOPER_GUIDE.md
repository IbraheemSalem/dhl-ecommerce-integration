# Developer Guide

This package follows a layered architecture:

- **Domain**: DTOs, entities, exceptions (`src/Domain`)
- **Application**: Services encapsulating DHL use-cases (`src/Services`)
- **Infrastructure**: HTTP client, webhook handling (`src/Http`, `src/Support`)
- **UI**: Admin Blade views, controllers, routes (`src/UI`, `routes/*`)

## Resolving Services

Use Laravel's IoC container:

```php
$shipment = app(Ibraheem\DhlEcommerceIntegration\Services\DhlShipmentService::class)
    ->create($dto);
```

## Extending

- Listen to `Ibraheem\DhlEcommerceIntegration\Events\DhlWebhookEvent` for webhook automation.
- Override bindings in `AppServiceProvider` if you need custom HTTP client behavior.
- Publish config, migrations, and assets to customize defaults.
