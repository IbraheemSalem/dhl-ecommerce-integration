<?php

namespace Ibraheem\DhlEcommerceIntegration\Services;

use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Ibraheem\DhlEcommerceIntegration\Domain\Exceptions\DhlApiException;
use Ibraheem\DhlEcommerceIntegration\Http\Clients\DhlHttpClient;

class DhlAuthenticator
{
    private const CACHE_KEY = 'dhl_ecommerce_token';

    public function __construct(
        private readonly DhlHttpClient $client,
        private readonly CacheRepository $cache
    ) {
    }

    public function getToken(): string
    {
        return $this->cache->remember(self::CACHE_KEY, 3500, function () {
            $response = $this->client->post('/auth/token', [
                'client_id' => config('dhl.client_id'),
                'client_secret' => config('dhl.client_secret'),
                'grant_type' => 'client_credentials',
            ], withAuth: false);

            if (!isset($response['access_token'])) {
                throw new DhlApiException('Invalid authentication response from DHL.');
            }

            return $response['access_token'];
        });
    }
}
