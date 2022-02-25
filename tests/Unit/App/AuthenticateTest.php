<?php

declare(strict_types=1);

namespace Tests\Unit\App;

use App\Http\Middleware\Authenticate;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Contracts\Auth\Factory;

final class AuthenticateTest extends TestCase
{
    use WithFaker;

    function test_authenticate_middleware()
    {
        $middleware = new class($this->app->make(Factory::class)) extends Authenticate
        {
            public function redirectToTest()
            {
                return $this->redirectTo(new Request());
            }
        };

        $result = $middleware->redirectToTest();

        $this->assertIsString($result);
    }
}
