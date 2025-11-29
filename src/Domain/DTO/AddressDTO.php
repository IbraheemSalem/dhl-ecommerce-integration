<?php

namespace Ibraheem\DhlEcommerceIntegration\Domain\DTO;

class AddressDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $street,
        public readonly string $city,
        public readonly string $state,
        public readonly string $postalCode,
        public readonly string $countryCode,
        public readonly ?string $phone = null,
        public readonly ?string $email = null
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'street' => $this->street,
            'city' => $this->city,
            'state' => $this->state,
            'postalCode' => $this->postalCode,
            'countryCode' => $this->countryCode,
            'phone' => $this->phone,
            'email' => $this->email,
        ];
    }
}
