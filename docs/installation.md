# Installation

1. Install package:
   ```bash
   composer require ibraheem/dhl-ecommerce-integration
   ```
2. Publish config & assets:
   ```bash
   php artisan vendor:publish --tag=dhl-config
   php artisan vendor:publish --tag=dhl-assets
   ```
3. Run migrations:
   ```bash
   php artisan migrate
   ```
4. Configure environment variables in `.env`.
