<?php

declare(strict_types=1);

namespace Tests\Unit\App;

use App\Exceptions\Handler;
use Exception;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;

final class HandlerTest extends TestCase
{
    use WithFaker;

    function test_handler()
    {
        $handler = new Handler($this->app->make(Container::class));

        $result = $handler->render(new Request(), new Exception());

        $this->assertNotNull($result);
    }
}
