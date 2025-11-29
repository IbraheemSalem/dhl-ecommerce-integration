<?php

namespace Ibraheem\DhlEcommerceIntegration\Tests\Unit;

use Ibraheem\DhlEcommerceIntegration\Domain\DTO\AddressDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\CreateShipmentDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\ShipmentItemDTO;
use PHPUnit\Framework\TestCase;

class CreateShipmentDTOTest extends TestCase
{
    public function test_it_converts_to_array(): void
    {
        $dto = new CreateShipmentDTO(
            shipper: new AddressDTO('Store', '123 Street', 'City', 'State', '11111', 'US'),
            recipient: new AddressDTO('Customer', '999 Road', 'City', 'State', '22222', 'US'),
            items: [new ShipmentItemDTO('Item', 1, 0.5, 50.0, '1234')],
            serviceType: 'EXPRESS',
            reference: 'ORD-1001'
        );

        $array = $dto->toArray();

        $this->assertSame('Store', $array['shipper']['name']);
        $this->assertCount(1, $array['items']);
        $this->assertSame('EXPRESS', $array['serviceType']);
        $this->assertSame('ORD-1001', $array['reference']);
    }
}
