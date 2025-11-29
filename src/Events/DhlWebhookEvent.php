<?php

namespace Ibraheem\DhlEcommerceIntegration\Events;

class DhlWebhookEvent
{
    public function __construct(public array $payload)
    {
    }
}
