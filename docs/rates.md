# Rates

Request rates via `DhlRateService` with a `RateRequestDTO`:

```php
$origin = new AddressDTO('Store', '123 St', 'Riyadh', 'Riyadh', '11111', 'SA');
$destination = new AddressDTO('Customer', '66 Rd', 'Jeddah', 'Makkah', '22222', 'SA');

$rates = app(DhlRateService::class)->getRates(
    new RateRequestDTO($origin, $destination, 1.4)
);
```

Each rate entry contains `service`, `currency`, `total`, and `estimated_delivery`.
