<?php

namespace Ibraheem\DhlEcommerceIntegration\Support;

use Ibraheem\DhlEcommerceIntegration\Domain\Entities\WebhookEvent;
use Illuminate\Support\Facades\Log;

class Logger
{
    public static function webhook(array $event): void
    {
        WebhookEvent::create([
            'event_type' => $event['eventType'] ?? 'unknown',
            'tracking_number' => $event['trackingNumber'] ?? null,
            'payload' => json_encode($event),
        ]);
    }

    public static function api(string $type, array $payload, array $response): void
    {
        WebhookEvent::create([
            'event_type' => "api_{$type}",
            'tracking_number' => $payload['tracking_number'] ?? null,
            'payload' => json_encode([
                'request' => $payload,
                'response' => $response,
            ]),
        ]);

        Log::info("DHL API {$type}", ['request' => $payload, 'response' => $response]);
    }
}
