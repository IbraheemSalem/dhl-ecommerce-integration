<?php

namespace Ibraheem\DhlEcommerceIntegration\Services;

use Ibraheem\DhlEcommerceIntegration\Domain\DTO\RateRequestDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\Exceptions\DhlApiException;
use Ibraheem\DhlEcommerceIntegration\Http\Clients\DhlHttpClient;
use Ibraheem\DhlEcommerceIntegration\Support\ResponseFormatter;

class DhlRateService
{
    public function __construct(private readonly DhlHttpClient $client)
    {
    }

    public function getRates(RateRequestDTO $dto): array
    {
        $payload = $dto->toArray();
        $response = $this->client->post('/rates', $payload);

        if (!isset($response['rates'])) {
            throw new DhlApiException('Invalid DHL rates response.');
        }

        return ResponseFormatter::rates($response);
    }
}
