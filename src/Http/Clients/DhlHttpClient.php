<?php

namespace Ibraheem\DhlEcommerceIntegration\Http\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Middleware;
use Ibraheem\DhlEcommerceIntegration\Domain\Exceptions\DhlApiException;
use Ibraheem\DhlEcommerceIntegration\Services\DhlAuthenticator;
use Ibraheem\DhlEcommerceIntegration\Support\Logger;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;

class DhlHttpClient
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('dhl.api_base'),
            'timeout' => config('dhl.timeout'),
        ]);
    }

    public function post(string $uri, array $payload, bool $withAuth = true): array
    {
        return $this->request('POST', $uri, ['json' => $payload], $withAuth);
    }

    public function get(string $uri, bool $withAuth = true): array
    {
        return $this->request('GET', $uri, [], $withAuth);
    }

    public function getRaw(string $uri): string
    {
        try {
            $response = $this->client->get($uri, [
                'headers' => $this->authHeaders(),
            ]);

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            throw DhlApiException::fromGuzzle($e);
        }
    }

    private function request(string $method, string $uri, array $options = [], bool $withAuth = true): array
    {
        if ($withAuth) {
            $options['headers'] = array_merge($options['headers'] ?? [], $this->authHeaders());
        }

        $options['headers']['Accept'] = 'application/json';

        $attempts = 0;
        $maxAttempts = 3;

        beginning:
        try {
            $attempts++;
            $response = $this->client->request($method, $uri, $options);
            $decoded = $this->decodeResponse($response);

            Logger::api(strtolower($method), $options['json'] ?? [], $decoded);

            return $decoded;
        } catch (RequestException $e) {
            $status = $e->getResponse()?->getStatusCode();
            if ($attempts < $maxAttempts && in_array($status, [408, 429, 500, 502, 503, 504], true)) {
                usleep(200000 * $attempts);
                goto beginning;
            }

            throw DhlApiException::fromGuzzle($e);
        }
    }

    private function decodeResponse(ResponseInterface $response): array
    {
        $body = $response->getBody()->getContents();

        return json_decode($body, true) ?? [];
    }

    private function authHeaders(): array
    {
        $token = app(DhlAuthenticator::class)->getToken();

        return [
            'Authorization' => "Bearer {$token}",
        ];
    }
}
