<?php

declare(strict_types=1);

namespace Tests\Unit\App;

use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;
use Shared\Infrastructure\Persistence\Eloquent\UserModel;

final class RedirectIfAuthenticatedTest extends TestCase
{
    use WithFaker;

    function test_redirect_if_authenticated_middleware()
    {
        $middleware = new RedirectIfAuthenticated($this->app);

        $next = $middleware->handle($this->app->make(Request::class), fn ($request) => $request);

        $user = new UserModel();
        $user->id = 1;
        $this->actingAs($user);

        $nextRedirect = $middleware->handle($this->app->make(Request::class), fn ($request) => $request, 'web');

        $this->assertIsObject($next);
        $this->assertIsObject($nextRedirect);
    }
}
