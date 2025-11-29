<?php

namespace Ibraheem\DhlEcommerceIntegration\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

class WebhookEvent extends Model
{
    protected $table = 'dhl_logs';

    protected $fillable = [
        'event_type',
        'tracking_number',
        'payload',
    ];
}
