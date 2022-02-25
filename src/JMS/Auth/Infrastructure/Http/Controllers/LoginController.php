<?php

declare(strict_types=1);

namespace JMS\Auth\Infrastructure\Http\Controllers;

use JMS\Auth\Application\Login\LoginQuery;
use Shared\Domain\Bus\Query\QueryBus;
use JMS\Auth\Infrastructure\Http\Requests\LoginRequest;
use JMS\Auth\Infrastructure\Http\Resources\LoginResource;

final class LoginController
{
    public function __construct(
        private QueryBus $queryBus
    ) {
    }

    public function __invoke(LoginRequest $request): LoginResource
    {
        $loginResponse = $this->queryBus->ask(
            new LoginQuery(
                $request->get('email'),
                $request->get('password')
            )
        );

        return new LoginResource($loginResponse);
    }
}