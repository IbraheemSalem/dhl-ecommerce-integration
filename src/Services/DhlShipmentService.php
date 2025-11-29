<?php

namespace Ibraheem\DhlEcommerceIntegration\Services;

use Ibraheem\DhlEcommerceIntegration\Domain\DTO\CreateShipmentDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\Exceptions\DhlApiException;
use Ibraheem\DhlEcommerceIntegration\Http\Clients\DhlHttpClient;
use Ibraheem\DhlEcommerceIntegration\Support\ResponseFormatter;

class DhlShipmentService
{
    public function __construct(private readonly DhlHttpClient $client)
    {
    }

    public function create(CreateShipmentDTO $dto): array
    {
        $payload = $dto->toArray();
        $payload['accountNumber'] = config('dhl.account_number');

        $response = $this->client->post('/shipments', $payload);

        if (!isset($response['shipmentId'])) {
            throw new DhlApiException('Invalid DHL shipment creation response.');
        }

        return ResponseFormatter::shipment($response);
    }

    public function cancel(string $shipmentId): array
    {
        $response = $this->client->post("/shipments/{$shipmentId}/cancel", []);

        return ResponseFormatter::cancel($response);
    }
}
