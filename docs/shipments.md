# Shipments

Use `Ibraheem\DhlEcommerceIntegration\Services\DhlShipmentService` together with `CreateShipmentDTO` to create DHL shipments.

```php
$service = app(DhlShipmentService::class);

$shipment = $service->create(
    new CreateShipmentDTO(
        shipper: new AddressDTO('Store', '123 St', 'Riyadh', 'Riyadh', '11111', 'SA'),
        recipient: new AddressDTO('Customer', '55 Road', 'Dubai', 'Dubai', '00001', 'AE'),
        items: [new ShipmentItemDTO('Shoes', 1, 0.7)],
        serviceType: 'EXPRESS',
        reference: 'ORDER-1001'
    )
);
```

The response is normalized and contains `shipment_id`, `tracking_number`, `label_url`, `status`, and full metadata.
