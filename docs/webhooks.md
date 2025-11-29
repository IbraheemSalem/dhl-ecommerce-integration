# Webhook Guide

Endpoint: `POST /dhl/webhook`

Headers:
- `X-DHL-Signature`: HMAC SHA256 signature.

The package verifies the signature using `config('dhl.webhook_secret')` then fires `DhlWebhookEvent` and logs payloads.

## Sample Payload
```json
{
  "eventType": "delivered",
  "trackingNumber": "1234567890",
  "occurredAt": "2025-11-17T12:00:00Z"
}
```

## Listening
```php
Event::listen(DhlWebhookEvent::class, function ($event) {
    // handle
});
```
