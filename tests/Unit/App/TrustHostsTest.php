<?php

declare(strict_types=1);

namespace Tests\Unit\App;

use Shared\Infrastructure\Http\Middleware\TrustHosts;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class TrustHostsTest extends TestCase
{
    use WithFaker;

    function test_trust_hosts_middleware()
    {
        $middleware = new TrustHosts($this->app);

        $hosts = $middleware->hosts();

        $this->assertIsArray($hosts);
    }
}
