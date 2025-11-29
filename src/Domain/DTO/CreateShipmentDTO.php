<?php

namespace Ibraheem\DhlEcommerceIntegration\Domain\DTO;

class CreateShipmentDTO
{
    /** @param ShipmentItemDTO[] $items */
    public function __construct(
        public readonly AddressDTO $shipper,
        public readonly AddressDTO $recipient,
        public readonly array $items,
        public readonly string $serviceType,
        public readonly ?string $reference = null,
        public readonly ?float $declaredValue = null,
        public readonly ?string $currency = 'USD'
    ) {
    }

    public function toArray(): array
    {
        return [
            'shipper' => $this->shipper->toArray(),
            'recipient' => $this->recipient->toArray(),
            'items' => array_map(fn (ShipmentItemDTO $item) => $item->toArray(), $this->items),
            'serviceType' => $this->serviceType,
            'reference' => $this->reference,
            'declaredValue' => $this->declaredValue,
            'currency' => $this->currency,
        ];
    }
}
