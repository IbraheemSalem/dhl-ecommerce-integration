<?php

namespace Ibraheem\DhlEcommerceIntegration\Domain\DTO;

class ShipmentItemDTO
{
    public function __construct(
        public readonly string $description,
        public readonly int $quantity,
        public readonly float $weight,
        public readonly ?float $value = null,
        public readonly ?string $hsCode = null
    ) {
    }

    public function toArray(): array
    {
        return [
            'description' => $this->description,
            'quantity' => $this->quantity,
            'weight' => $this->weight,
            'value' => $this->value,
            'hsCode' => $this->hsCode,
        ];
    }
}
