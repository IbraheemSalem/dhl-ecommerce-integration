# Configuration

Publish the config file using:

```bash
php artisan vendor:publish --tag=dhl-config
```

Available keys in `config/dhl.php`:

- `api_base`: DHL eCommerce base URL
- `client_id`: OAuth client id provided by DHL
- `client_secret`: OAuth secret
- `account_number`: Default shipping account
- `webhook_secret`: Secret token used to verify webhook signatures
- `timeout`: HTTP timeout in seconds

Override any value using environment variables (`DHL_ECOMMERCE_*`).
