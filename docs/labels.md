# Labels

Retrieve shipment labels through `DhlLabelService`:

```php
$labelContent = app(DhlLabelService::class)->get('TRACK123456', 'pdf');
Storage::disk('local')->put('labels/TRACK123456.pdf', $labelContent);
```

Supported formats: `pdf`, `png`. The service downloads the raw binary from DHL and throws `DhlApiException` if the label is missing.
