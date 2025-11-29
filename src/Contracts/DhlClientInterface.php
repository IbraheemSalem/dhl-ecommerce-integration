<?php

namespace Ibraheem\DhlEcommerceIntegration\Contracts;

use Ibraheem\DhlEcommerceIntegration\Domain\DTO\CreateShipmentDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\RateRequestDTO;

interface DhlClientInterface
{
    public function authenticate(): string;

    public function createShipment(CreateShipmentDTO $dto): array;

    public function getRates(RateRequestDTO $dto): array;

    public function track(string $trackingNumber): array;

    public function cancel(string $shipmentId): array;

    public function getLabel(string $trackingNumber, string $format = 'pdf'): string;
}
