<?php

namespace Ibraheem\DhlEcommerceIntegration\Services;

use Ibraheem\DhlEcommerceIntegration\Domain\Exceptions\DhlApiException;
use Ibraheem\DhlEcommerceIntegration\Http\Clients\DhlHttpClient;

class DhlLabelService
{
    public function __construct(private readonly DhlHttpClient $client)
    {
    }

    public function get(string $trackingNumber, string $format = 'pdf'): string
    {
        $content = $this->client->getRaw("/labels/{$trackingNumber}?format={$format}");

        if (empty($content)) {
            throw new DhlApiException('Failed to download DHL label.');
        }

        return $content;
    }
}
