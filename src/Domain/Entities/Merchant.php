<?php

namespace Ibraheem\DhlEcommerceIntegration\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    protected $table = 'dhl_merchants';

    protected $fillable = [
        'name',
        'client_id',
        'client_secret',
        'account_number',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}
