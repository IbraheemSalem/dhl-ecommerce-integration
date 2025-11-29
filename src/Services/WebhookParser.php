<?php

namespace Ibraheem\DhlEcommerceIntegration\Services;

class WebhookParser
{
    public static function trackingNumber(array $data): ?string
    {
        return $data['trackingNumber'] ?? null;
    }

    public static function eventType(array $data): string
    {
        return $data['eventType'] ?? 'unknown';
    }
}
