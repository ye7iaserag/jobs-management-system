<?php

declare(strict_types=1);

namespace Tests\Unit\App;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Support\Facades\RateLimiter;

final class RouteServiceProviderTest extends TestCase
{
    use WithFaker;

    function test_route_service_provider()
    {
        $provider = new class($this->app) extends RouteServiceProvider
        {
            public function loadRoutesTest()
            {
                $this->loadRoutes();
            }
        };

        $provider->register();

        $provider->boot();

        $provider->loadRoutesTest();

        $limiter = RateLimiter::limiter('api');

        $limitResult = $limiter($this->app->make(Request::class));

        $this->assertInstanceOf(\Illuminate\Cache\RateLimiting\Limit::class, $limitResult);
    }
}
