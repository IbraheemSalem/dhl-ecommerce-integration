<?php

namespace Ibraheem\DhlEcommerceIntegration\Tests\Feature;

use Ibraheem\DhlEcommerceIntegration\Domain\DTO\AddressDTO;
use Ibraheem\DhlEcommerceIntegration\Domain\DTO\RateRequestDTO;
use Ibraheem\DhlEcommerceIntegration\Services\DhlRateService;
use Ibraheem\DhlEcommerceIntegration\Tests\Fakes\FakeDhlHttpClient;
use Ibraheem\DhlEcommerceIntegration\Tests\TestCase;

class RateTest extends TestCase
{
    public function test_rates_return_array(): void
    {
        $client = new FakeDhlHttpClient();
        $client->setResponse('POST', '/rates', [
            'rates' => [[
                'service' => 'EXPRESS',
                'currency' => 'USD',
                'total' => 25.5,
            ]],
        ]);

        $service = new DhlRateService($client);

        $origin = new AddressDTO('Store', '123 St', 'NYC', 'NY', '10001', 'US');
        $destination = new AddressDTO('Customer', '55 Road', 'LA', 'CA', '90001', 'US');
        $dto = new RateRequestDTO($origin, $destination, 1.5);

        $rates = $service->getRates($dto);

        $this->assertIsArray($rates);
        $this->assertSame('EXPRESS', $rates[0]['service']);
    }
}
