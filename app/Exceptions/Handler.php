<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use Shared\Domain\Port\DomainException;
use Shared\Infrastructure\Constants\Error;
use Shared\Infrastructure\Exceptions\AuthorizationException;
use Shared\Infrastructure\Exceptions\HandlerFailedException as ExceptionsHandlerFailedException;
use Shared\Infrastructure\Exceptions\InfrastructureException;
use Shared\Infrastructure\Exceptions\UnknownErrorException;
use Shared\Infrastructure\Exceptions\ValidationException;
use Shared\Infrastructure\Http\Resources\ErrorsResource;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        $previous = $e->getPrevious();
        if ($e instanceof HandlerFailedException) {
            throw new ExceptionsHandlerFailedException(Error::HANDLER_FAILED);
        }
        if ($e instanceof UnauthorizedHttpException && $previous instanceof TokenExpiredException) {
            throw new AuthorizationException(Error::TOKEN_EXPIRED);
        }
        if ($e instanceof UnauthorizedHttpException && $previous instanceof TokenInvalidException) {
            throw new AuthorizationException(Error::TOKEN_INVALID);
        }
        if ($e instanceof ValidationException) {
            return new JsonResponse(new ErrorsResource(['errors'=>[['code'=>$e->getCode(), 'msg'=>$e->getMessage(), 'data' => $e->getValidationErrors()]]]), Error::HTTP_CODE[$e->getCode()]);
        }
        if ($e instanceof DomainException) {
            return new JsonResponse(new ErrorsResource(['errors'=>[['code'=>$e->getCode(), 'msg'=>$e->getMessage()]]]), Error::HTTP_CODE[Error::INVALID_INPUTS]);
        }
        if ($e instanceof InfrastructureException) {
            return new JsonResponse(new ErrorsResource(['errors'=>[['code'=>$e->getCode(), 'msg'=>$e->getMessage()]]]), Error::HTTP_CODE[$e->getCode()]);
        }

        throw new UnknownErrorException();
    }
}
