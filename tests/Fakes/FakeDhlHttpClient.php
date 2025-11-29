<?php

namespace Ibraheem\DhlEcommerceIntegration\Tests\Fakes;

use Ibraheem\DhlEcommerceIntegration\Http\Clients\DhlHttpClient;

class FakeDhlHttpClient extends DhlHttpClient
{
    private array $responses = [];

    public function __construct()
    {
        // Skip parent constructor to avoid real HTTP client setup
    }

    public function setResponse(string $method, string $uri, mixed $response): void
    {
        $key = strtoupper($method) . ':' . $uri;
        $this->responses[$key] = $response;
    }

    public function post(string $uri, array $payload, bool $withAuth = true): array
    {
        return $this->responses['POST:' . $uri] ?? [];
    }

    public function get(string $uri, bool $withAuth = true): array
    {
        return $this->responses['GET:' . $uri] ?? [];
    }

    public function getRaw(string $uri): string
    {
        return $this->responses['RAW:' . $uri] ?? '';
    }
}
