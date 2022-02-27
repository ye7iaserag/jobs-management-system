<?php

declare(strict_types=1);

namespace JMS\Auth\Application\Response;

use JMS\Auth\Domain\DTO\Users;
use Shared\Domain\Bus\Query\Response;

final class UsersResponse implements Response
{
    /** @var array<UserResponse> */
    private array $users;

    public function __construct(array $users)
    {
        $this->users = $users;
    }

    public static function fromUsers(Users $users): self
    {
        $usersResponse = array_map(
            function ($user) {
                return UserResponse::fromUser($user);
            },
            $users->all()
        );

        return new self($usersResponse);
    }

    public function toArray(): array
    {
        return array_map(function (UserResponse $userResponse) {
            return $userResponse->toArray();
        }, $this->users);
    }
}
