<?php

namespace Ibraheem\DhlEcommerceIntegration\Tests;

use Ibraheem\DhlEcommerceIntegration\Providers\DhlServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [DhlServiceProvider::class];
    }
}
