<?php

namespace Ibraheem\DhlEcommerceIntegration\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        'shipment_id',
        'tracking_number',
        'status',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
    ];
}
