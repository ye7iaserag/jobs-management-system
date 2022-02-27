<?php

declare(strict_types=1);

namespace JMS\Auth\Application\Login;

use JMS\Auth\Application\Response\LoginResponse;
use JMS\Auth\Domain\ValueObject\{ UserEmail, UserPassword, JwtToken };
use JMS\Auth\Domain\Port\UserRepository;
use JMS\Auth\Domain\Exception\UserNotFound;
use JMS\Auth\Domain\Port\JwtRepository;
use JMS\Auth\Domain\Port\HashService;
use Shared\Domain\Bus\Query\QueryHandler;

final class LoginQueryHandler implements QueryHandler
{

    public function __construct(private UserRepository $repository, private JwtRepository $jwt, private HashService $hash)
    {
    }

    public function __invoke(LoginQuery $query): LoginResponse
    {
        $email  = UserEmail::fromValue($query->email());
        $plainPassword = UserPassword::fromValue($query->password());
        
        $user = $this->repository->findByEmail($email);

        if (null === $user) {
            throw new UserNotFound;
        }
        if (!$this->hash->check($plainPassword, $user->password())) {
            throw new UserNotFound;
        }
        $token = $this->jwt->getToken($user);

        return LoginResponse::fromJwtToken($token);
    }
}
