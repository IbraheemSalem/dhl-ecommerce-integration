<?php

namespace Ibraheem\DhlEcommerceIntegration\Domain\DTO;

class RateRequestDTO
{
    public function __construct(
        public readonly AddressDTO $origin,
        public readonly AddressDTO $destination,
        public readonly float $weight,
        public readonly ?string $serviceType = null,
        public readonly ?float $declaredValue = null,
        public readonly ?string $currency = 'USD'
    ) {
    }

    public function toArray(): array
    {
        return [
            'origin' => $this->origin->toArray(),
            'destination' => $this->destination->toArray(),
            'weight' => $this->weight,
            'serviceType' => $this->serviceType,
            'declaredValue' => $this->declaredValue,
            'currency' => $this->currency,
        ];
    }
}
