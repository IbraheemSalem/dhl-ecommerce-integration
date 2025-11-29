<?php

namespace Ibraheem\DhlEcommerceIntegration\Services;

use Ibraheem\DhlEcommerceIntegration\Contracts\DhlWebhookInterface;
use Ibraheem\DhlEcommerceIntegration\Events\DhlWebhookEvent;
use Ibraheem\DhlEcommerceIntegration\Support\Logger;

class DhlWebhookService implements DhlWebhookInterface
{
    public function verifySignature(string $payload, string $signature): bool
    {
        $secret = config('dhl.webhook_secret');
        $expected = hash_hmac('sha256', $payload, $secret ?? '');

        return hash_equals($expected, (string) $signature);
    }

    public function handle(array $event): void
    {
        Logger::webhook($event);

        event(new DhlWebhookEvent($event));
    }
}
