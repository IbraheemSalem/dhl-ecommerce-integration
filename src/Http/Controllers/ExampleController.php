<?php

namespace Ibraheem\DhlEcommerceIntegration\Http\Controllers;

use Illuminate\Routing\Controller;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\AddressDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\CreateShipmentDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\ShipmentItemDTO;
use Ibraheem\DhlEcommerceIntegration\Services\DhlShipmentService;

class ExampleController extends Controller
{
    public function createShipment(DhlShipmentService $service)
    {
        $dto = new CreateShipmentDTO(
            shipper: new AddressDTO('Ibraheem Store', '123 King St', 'Riyadh', 'Riyadh', '11111', 'SA'),
            recipient: new AddressDTO('John Smith', '55 Queen Ave', 'London', 'London', 'SW1A', 'GB'),
            items: [new ShipmentItemDTO('Sample Box', 1, 0.5)],
            serviceType: 'EXPRESS',
            reference: 'ORDER-2001'
        );

        return response()->json($service->create($dto));
    }
}
