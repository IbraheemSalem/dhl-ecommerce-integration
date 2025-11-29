<?php

namespace Ibraheem\DhlEcommerceIntegration\Tests\Unit;

use Ibraheem\DhlEcommerceIntegration\Domain\DTO\AddressDTO;
use PHPUnit\Framework\TestCase;

class DTOTest extends TestCase
{
    public function test_address_dto_serializes_correctly(): void
    {
        $dto = new AddressDTO(
            name: 'John Doe',
            street: '123 Main',
            city: 'Riyadh',
            state: 'Riyadh',
            postalCode: '12345',
            countryCode: 'SA',
            phone: '0555555555',
            email: 'john@example.com'
        );

        $array = $dto->toArray();

        $this->assertSame('John Doe', $array['name']);
        $this->assertSame('0555555555', $array['phone']);
        $this->assertSame('john@example.com', $array['email']);
    }
}
