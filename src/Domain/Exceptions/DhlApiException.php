<?php

namespace Ibraheem\DhlEcommerceIntegration\Domain\Exceptions;

use GuzzleHttp\Exception\RequestException;

class DhlApiException extends DhlException
{
    public static function fromGuzzle(RequestException $e): self
    {
        $body = $e->getResponse()?->getBody()?->getContents();
        $json = json_decode($body ?? '', true);

        $message = $json['message'] ?? $json['detail'] ?? $e->getMessage();
        $code = $e->getResponse()?->getStatusCode() ?? $e->getCode();

        return new self($message, $code, $e);
    }
}
