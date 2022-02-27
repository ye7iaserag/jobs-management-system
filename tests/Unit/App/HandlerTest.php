<?php

declare(strict_types=1);

namespace Tests\Unit\App;

use App\Exceptions\Handler;
use Exception;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JMS\Job\Domain\Exceptions\JobNotFound;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use Shared\Infrastructure\Exception\AuthorizationException;
use Shared\Infrastructure\Exception\HandlerFailedException as ExceptionsHandlerFailedException;
use Shared\Infrastructure\Exception\InfrastructureException;
use Shared\Infrastructure\Exception\UnknownErrorException;
use Shared\Infrastructure\Exception\ValidationException;
use stdClass;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

final class HandlerTest extends TestCase
{
    use WithFaker;

    function test_handler_unknown_error_exception()
    {
        $handler = new Handler($this->app->make(Container::class));

        $this->expectException(UnknownErrorException::class);

        $result = $handler->render(new Request(), new Exception());

        $this->assertNotNull($result);
    }

    function test_handler_token_expired_exception()
    {
        $handler = new Handler($this->app->make(Container::class));

        $this->expectException(AuthorizationException::class);

        $exception = new UnauthorizedHttpException('', '', new TokenExpiredException());

        $result = $handler->render(new Request(), $exception);

        $this->assertNotNull($result);
    }

    function test_handler_token_invalid_exception()
    {
        $handler = new Handler($this->app->make(Container::class));

        $this->expectException(AuthorizationException::class);

        $exception = new UnauthorizedHttpException('', '', new TokenInvalidException());

        $result = $handler->render(new Request(), $exception);

        $this->assertNotNull($result);
    }

    function test_handler_domain_exception()
    {
        $handler = new Handler($this->app->make(Container::class));

        $exception = new JobNotFound();

        $result = $handler->render(new Request(), $exception);

        $this->assertInstanceOf(JsonResponse::class, $result);
    }

    function test_handler_infrastructure_exception()
    {
        $handler = new Handler($this->app->make(Container::class));

        $exception = new class extends InfrastructureException{};

        $result = $handler->render(new Request(), $exception);

        $this->assertInstanceOf(JsonResponse::class, $result);
    }

    function test_handler_validation_exception()
    {
        $handler = new Handler($this->app->make(Container::class));

        $exception = new ValidationException([$this->faker->uuid()]);

        $result = $handler->render(new Request(), $exception);

        $this->assertInstanceOf(JsonResponse::class, $result);
    }

    function test_handler_handler_exception()
    {
        $handler = new Handler($this->app->make(Container::class));

        $this->expectException(ExceptionsHandlerFailedException::class);

        $exception = new HandlerFailedException(new Envelope(new stdClass),[new Exception()]);

        $handler->render(new Request(), $exception);
    }
}
