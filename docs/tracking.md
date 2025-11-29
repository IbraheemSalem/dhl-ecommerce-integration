# Tracking

Use `DhlTrackingService` to track shipments by tracking number:

```php
$status = app(DhlTrackingService::class)->track('TRACK123456');
```

The response contains:

- `tracking_number`
- `status`
- `history` events array
- `estimated_delivery`
