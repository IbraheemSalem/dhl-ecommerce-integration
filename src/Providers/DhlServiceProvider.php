<?php

namespace Ibraheem\DhlEcommerceIntegration\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Ibraheem\DhlEcommerceIntegration\Contracts\DhlClientInterface;
use Ibraheem\DhlEcommerceIntegration\Contracts\DhlWebhookInterface;
use Ibraheem\DhlEcommerceIntegration\Events\DhlWebhookEvent;
use Ibraheem\DhlEcommerceIntegration\Http\Clients\DhlHttpClient;
use Ibraheem\DhlEcommerceIntegration\Listeners\ProcessWebhookEvent;
use Ibraheem\DhlEcommerceIntegration\Services\DhlAuthenticator;
use Ibraheem\DhlEcommerceIntegration\Services\DhlClient;
use Ibraheem\DhlEcommerceIntegration\Services\DhlLabelService;
use Ibraheem\DhlEcommerceIntegration\Services\DhlRateService;
use Ibraheem\DhlEcommerceIntegration\Services\DhlShipmentService;
use Ibraheem\DhlEcommerceIntegration\Services\DhlTrackingService;
use Ibraheem\DhlEcommerceIntegration\Services\DhlWebhookService;

class DhlServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/dhl.php', 'dhl');

        $this->app->singleton(DhlHttpClient::class, function () {
            return new DhlHttpClient();
        });

        $this->app->singleton(DhlAuthenticator::class, function ($app) {
            return new DhlAuthenticator(
                $app->make(DhlHttpClient::class),
                Cache::store(config('cache.default'))
            );
        });

        $this->app->singleton(DhlWebhookInterface::class, function ($app) {
            return $app->make(DhlWebhookService::class);
        });

        $this->app->bind(DhlShipmentService::class, function ($app) {
            return new DhlShipmentService($app->make(DhlHttpClient::class));
        });

        $this->app->bind(DhlRateService::class, function ($app) {
            return new DhlRateService($app->make(DhlHttpClient::class));
        });

        $this->app->bind(DhlTrackingService::class, function ($app) {
            return new DhlTrackingService($app->make(DhlHttpClient::class));
        });

        $this->app->bind(DhlLabelService::class, function ($app) {
            return new DhlLabelService($app->make(DhlHttpClient::class));
        });

        $this->app->singleton(DhlClient::class, function ($app) {
            return new DhlClient(
                $app->make(DhlAuthenticator::class),
                $app->make(DhlShipmentService::class),
                $app->make(DhlRateService::class),
                $app->make(DhlTrackingService::class),
                $app->make(DhlLabelService::class)
            );
        });

        $this->app->singleton(DhlClientInterface::class, function ($app) {
            return $app->make(DhlClient::class);
        });
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/admin.php');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/webhook.php');
        $this->loadViewsFrom(__DIR__ . '/../UI/Views', 'dhl');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/dhl.php' => config_path('dhl.php'),
            ], 'dhl-config');

            $this->publishes([
                __DIR__ . '/../UI/Views' => resource_path('views/vendor/dhl'),
            ], 'dhl-views');

            $this->publishes([
                __DIR__ . '/../../public/assets' => public_path('vendor/dhl'),
            ], 'dhl-assets');
        }

        Event::listen(DhlWebhookEvent::class, [ProcessWebhookEvent::class, 'handle']);
    }
}
