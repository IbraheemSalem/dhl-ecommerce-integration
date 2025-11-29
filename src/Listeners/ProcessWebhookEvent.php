<?php

namespace Ibraheem\DhlEcommerceIntegration\Listeners;

use Ibraheem\DhlEcommerceIntegration\Events\DhlWebhookEvent;
use Ibraheem\DhlEcommerceIntegration\Jobs\ProcessCancelled;
use Ibraheem\DhlEcommerceIntegration\Jobs\ProcessDelivered;
use Ibraheem\DhlEcommerceIntegration\Jobs\ProcessInTransit;
use Ibraheem\DhlEcommerceIntegration\Jobs\ProcessShipmentCreated;

class ProcessWebhookEvent
{
    public function handle(DhlWebhookEvent $event): void
    {
        $data = $event->payload;
        $eventType = $data['eventType'] ?? null;

        match ($eventType) {
            'shipment_created' => ProcessShipmentCreated::dispatch($data),
            'in_transit' => ProcessInTransit::dispatch($data),
            'delivered' => ProcessDelivered::dispatch($data),
            'cancelled' => ProcessCancelled::dispatch($data),
            default => null,
        };
    }
}
