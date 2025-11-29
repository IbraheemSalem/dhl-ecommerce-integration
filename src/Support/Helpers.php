<?php

namespace Ibraheem\DhlEcommerceIntegration\Support;

class Helpers
{
    public static function mask(string $value, int $visible = 4): string
    {
        $length = strlen($value);
        if ($length <= $visible) {
            return $value;
        }

        return str_repeat('*', $length - $visible) . substr($value, -$visible);
    }
}
