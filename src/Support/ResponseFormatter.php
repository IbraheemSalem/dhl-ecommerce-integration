<?php

namespace Ibraheem\DhlEcommerceIntegration\Support;

class ResponseFormatter
{
    public static function shipment(array $res): array
    {
        return [
            'shipment_id' => $res['shipmentId'],
            'tracking_number' => $res['trackingNumber'] ?? null,
            'label_url' => $res['labelUrl'] ?? null,
            'status' => $res['status'] ?? 'created',
            'meta' => $res,
        ];
    }

    public static function cancel(array $res): array
    {
        return [
            'shipment_id' => $res['shipmentId'] ?? null,
            'status' => $res['status'] ?? 'cancelled',
            'message' => $res['message'] ?? 'Shipment cancelled',
        ];
    }

    public static function rates(array $res): array
    {
        return array_map(function ($rate) {
            return [
                'service' => $rate['service'] ?? null,
                'currency' => $rate['currency'] ?? null,
                'total' => $rate['total'] ?? null,
                'estimated_delivery' => $rate['estimatedDelivery'] ?? null,
            ];
        }, $res['rates']);
    }

    public static function tracking(array $res): array
    {
        return [
            'tracking_number' => $res['trackingNumber'] ?? null,
            'status' => $res['status'] ?? null,
            'history' => $res['history'] ?? [],
            'estimated_delivery' => $res['estimatedDelivery'] ?? null,
        ];
    }
}
