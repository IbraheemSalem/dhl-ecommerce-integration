<?php

namespace Ibraheem\DhlEcommerceIntegration\Tests\Feature;

use Ibraheem\DhlEcommerceIntegration\Domain\DTO\AddressDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\CreateShipmentDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\ShipmentItemDTO;
use Ibraheem\DhlEcommerceIntegration\Services\DhlShipmentService;
use Ibraheem\DhlEcommerceIntegration\Tests\Fakes\FakeDhlHttpClient;
use Ibraheem\DhlEcommerceIntegration\Tests\TestCase;

class ShipmentTest extends TestCase
{
    public function test_shipment_creation_requires_valid_dto(): void
    {
        $service = new DhlShipmentService(new FakeDhlHttpClient());

        $this->expectException(\TypeError::class);
        /** @phpstan-ignore-next-line intentionally wrong type */
        $service->create(null);
    }

    public function test_shipment_creation_returns_normalized_response(): void
    {
        $client = new FakeDhlHttpClient();
        $client->setResponse('POST', '/shipments', [
            'shipmentId' => 'SHP123',
            'trackingNumber' => 'TRK123',
            'status' => 'created',
        ]);

        $service = new DhlShipmentService($client);

        $dto = new CreateShipmentDTO(
            shipper: new AddressDTO('Store', '123 St', 'City', 'State', '10001', 'US'),
            recipient: new AddressDTO('Customer', '77 Road', 'Town', 'Province', '20002', 'US'),
            items: [new ShipmentItemDTO('Item', 1, 0.5)],
            serviceType: 'EXPRESS'
        );

        $shipment = $service->create($dto);

        $this->assertSame('SHP123', $shipment['shipment_id']);
        $this->assertSame('TRK123', $shipment['tracking_number']);
    }
}
