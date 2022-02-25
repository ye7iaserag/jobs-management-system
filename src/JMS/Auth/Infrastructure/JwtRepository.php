<?php

declare(strict_types=1);

namespace JMS\Auth\Infrastructure;

use JMS\Auth\Domain\Entity\User;
use JMS\Auth\Infrastructure\Persistence\Eloquent\UserModel;
use JMS\Auth\Domain\JwtRepository as JwtRepositoryInterface;
use JMS\Auth\Domain\ValueObject\JwtToken;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

final class JwtRepository implements JwtRepositoryInterface
{

    public function getToken(User $user): ?JwtToken
    {
        $userModel = new UserModel();
        $userModel->id = $user->id()->value();
        $token = JWTAuth::fromUser($userModel);
        return $this->toDomain($token);
    }

    private function toDomain(string $token): JwtToken
    {
        return JwtToken::fromValue($token);
    }
}
