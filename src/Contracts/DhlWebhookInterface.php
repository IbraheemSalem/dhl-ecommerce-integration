<?php

namespace Ibraheem\DhlEcommerceIntegration\Contracts;

interface DhlWebhookInterface
{
    public function verifySignature(string $payload, string $signature): bool;

    public function handle(array $event): void;
}
