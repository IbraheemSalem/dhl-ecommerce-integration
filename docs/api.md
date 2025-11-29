# API Endpoints

## Shipments
- `POST /shipments` create shipment
- `POST /shipments/{id}/cancel` cancel shipment

## Rates
- `POST /rates` retrieve available services

## Tracking
- `GET /track/{trackingNumber}` track shipment

## Labels
- `GET /labels/{trackingNumber}` download PDF

All requests require Bearer token obtained automatically by the package.
