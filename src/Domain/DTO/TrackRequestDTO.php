<?php

namespace Ibraheem\DhlEcommerceIntegration\Domain\DTO;

class TrackRequestDTO
{
    public function __construct(
        public readonly string $trackingNumber,
        public readonly ?string $language = null
    ) {
    }

    public function toArray(): array
    {
        return [
            'trackingNumber' => $this->trackingNumber,
            'language' => $this->language,
        ];
    }
}
