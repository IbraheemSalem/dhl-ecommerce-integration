<?php

namespace Ibraheem\DhlEcommerceIntegration\Services;

use Ibraheem\DhlEcommerceIntegration\Contracts\DhlClientInterface;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\CreateShipmentDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\RateRequestDTO;

class DhlClient implements DhlClientInterface
{
    public function __construct(
        private readonly DhlAuthenticator $authenticator,
        private readonly DhlShipmentService $shipments,
        private readonly DhlRateService $rates,
        private readonly DhlTrackingService $tracking,
        private readonly DhlLabelService $labels
    ) {
    }

    public function authenticate(): string
    {
        return $this->authenticator->getToken();
    }

    public function createShipment(CreateShipmentDTO $dto): array
    {
        return $this->shipments->create($dto);
    }

    public function getRates(RateRequestDTO $dto): array
    {
        return $this->rates->getRates($dto);
    }

    public function track(string $trackingNumber): array
    {
        return $this->tracking->track($trackingNumber);
    }

    public function cancel(string $shipmentId): array
    {
        return $this->shipments->cancel($shipmentId);
    }

    public function getLabel(string $trackingNumber, string $format = 'pdf'): string
    {
        return $this->labels->get($trackingNumber, $format);
    }
}
