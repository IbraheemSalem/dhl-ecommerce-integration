<?php

namespace Ibraheem\DhlEcommerceIntegration\Services;

use Ibraheem\DhlEcommerceIntegration\Domain\Exceptions\DhlApiException;
use Ibraheem\DhlEcommerceIntegration\Http\Clients\DhlHttpClient;
use Ibraheem\DhlEcommerceIntegration\Support\ResponseFormatter;

class DhlTrackingService
{
    public function __construct(private readonly DhlHttpClient $client)
    {
    }

    public function track(string $trackingNumber): array
    {
        $response = $this->client->get("/track/{$trackingNumber}");

        if (!isset($response['status'])) {
            throw new DhlApiException('Invalid DHL tracking response.');
        }

        return ResponseFormatter::tracking($response);
    }
}
