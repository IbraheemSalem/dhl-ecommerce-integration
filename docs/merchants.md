# Merchant Management

Merchants are stored in the `dhl_merchants` table. Use the admin UI (`/dhl-admin/merchants`) to:

1. Add merchant credentials (name, client id, client secret, account number)
2. Toggle activation by editing the record in the database or extending the controller
3. View existing merchants and their status

You may replace the built-in UI with your own service layer by interacting with the `Merchant` model located at `src/Domain/Entities/Merchant.php`.
