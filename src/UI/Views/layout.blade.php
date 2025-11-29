<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DHL eCommerce Integration</title>
    <link rel="stylesheet" href="{{ asset('vendor/dhl/dhl.css') }}">
</head>
<body>
<div class="dhl-wrapper">
    <header class="dhl-header">
        <h2>DHL eCommerce Integration</h2>
        <nav>
            <a href="{{ route('dhl.admin.index') }}">Dashboard</a>
            <a href="{{ route('dhl.admin.settings') }}">Settings</a>
            <a href="{{ route('dhl.admin.merchants') }}">Merchants</a>
            <a href="{{ route('dhl.admin.logs') }}">Logs</a>
        </nav>
    </header>
    <main class="dhl-content">
        @yield('content')
    </main>
</div>
<script src="{{ asset('vendor/dhl/dhl.js') }}"></script>
</body>
</html>
