<?php

namespace Ibraheem\DhlEcommerceIntegration\Tests\Unit;

use Ibraheem\DhlEcommerceIntegration\Support\ResponseFormatter;
use PHPUnit\Framework\TestCase;

class ResponseFormatterTest extends TestCase
{
    public function test_shipment_format(): void
    {
        $response = ResponseFormatter::shipment([
            'shipmentId' => 'SHP123',
            'trackingNumber' => 'TRK123'
        ]);

        $this->assertSame('SHP123', $response['shipment_id']);
        $this->assertSame('TRK123', $response['tracking_number']);
    }

    public function test_rates_format(): void
    {
        $response = ResponseFormatter::rates([
            'rates' => [
                ['service' => 'EXPRESS', 'currency' => 'USD', 'total' => 20.5]
            ],
        ]);

        $this->assertSame('EXPRESS', $response[0]['service']);
        $this->assertSame(20.5, $response[0]['total']);
    }
}
