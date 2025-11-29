<?php

namespace Ibraheem\DhlEcommerceIntegration\Tests\Feature;

use Ibraheem\DhlEcommerceIntegration\Tests\TestCase;

class WebhookTest extends TestCase
{
    protected function defineEnvironment($app)
    {
        $app['config']->set('dhl.webhook_secret', 'secret');
    }

    public function test_webhook_rejects_invalid_signature(): void
    {
        $response = $this->postJson('/dhl/webhook', ['eventType' => 'shipment_created']);

        $response->assertStatus(401)->assertJson(['error' => 'Invalid signature']);
    }

    public function test_webhook_accepts_valid_signature(): void
    {
        $payload = ['eventType' => 'shipment_created', 'trackingNumber' => 'TRK'];
        $json = json_encode($payload);
        $signature = hash_hmac('sha256', $json, 'secret');

        $response = $this->withHeaders([
            'X-DHL-Signature' => $signature,
        ])->postJson('/dhl/webhook', $payload);

        $response->assertStatus(200)->assertJson(['status' => 'received']);
    }
}
