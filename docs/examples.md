# Examples

## Controller Example

```php
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\AddressDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\CreateShipmentDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\ShipmentItemDTO;
use Ibraheem\DhlEcommerceIntegration\Services\DhlShipmentService;

class ShippingController extends Controller
{
    public function store(DhlShipmentService $service)
    {
        $dto = new CreateShipmentDTO(
            shipper: new AddressDTO('Store', '123 St', 'Riyadh', 'Riyadh', '11111', 'SA'),
            recipient: new AddressDTO('Customer', '55 Rd', 'Dubai', 'Dubai', '00001', 'AE'),
            items: [new ShipmentItemDTO('Shoes', 1, 0.7)],
            serviceType: 'EXPRESS'
        );

        return response()->json($service->create($dto));
    }
}
```

## CLI Example

```bash
php artisan tinker --execute=\"app(\\\\Ibraheem\\\\DhlEcommerceIntegration\\\\Services\\\\DhlTrackingService::class)->track('TRACK123');\"
```

(Use a custom artisan command or scheduler to wrap the service calls in your project.)
