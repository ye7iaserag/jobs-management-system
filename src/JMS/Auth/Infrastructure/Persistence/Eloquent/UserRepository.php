<?php

declare(strict_types=1);

namespace JMS\Auth\Infrastructure\Persistence\Eloquent;

use JMS\Auth\Domain\Entity\User;
use JMS\Auth\Domain\ValueObject\UserEmail;
use JMS\Auth\Domain\Port\UserRepository as UserRepositoryInterface;
use JMS\Auth\Domain\DTO\Users;
use JMS\Auth\Domain\DTO\UsersFiltration;

final class UserRepository implements UserRepositoryInterface
{
    private UserModel $model;

    public function __construct(UserModel $model)
    {
        $this->model = $model;
    }

    public function findByEmail(UserEmail $email): ?User
    {
        $eloquentUser = $this->model->where('email', $email->value())->first();

        if (null === $eloquentUser) {
            return null;
        }

        return $this->toDomain($eloquentUser);
    }

    public function list(UsersFiltration $filtration): Users
    {
        $eloquentUsers = $this->model;
        if($filtration->role())
            $eloquentUsers = $eloquentUsers->where('role', $filtration->role()->value()->value);

        $result = $eloquentUsers->get();

        $users = $result->map(
            function (UserModel $eloquentUser) {
                return $this->toDomain($eloquentUser);
            }
        )->toArray();

        return new Users($users);
    }

    private function toDomain(UserModel $eloquentUserModel): User
    {
        return User::fromPrimitives(
            $eloquentUserModel->id,
            $eloquentUserModel->email,
            $eloquentUserModel->password,
            $eloquentUserModel->role
        );
    }
}
