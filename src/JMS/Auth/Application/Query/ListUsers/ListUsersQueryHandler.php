<?php

declare(strict_types=1);

namespace JMS\Auth\Application\Query\ListUsers;

use JMS\Auth\Application\Response\UsersResponse;
use JMS\Auth\Domain\Port\UserRepository;
use Shared\Domain\Bus\Query\QueryHandler;

final class ListUsersQueryHandler implements QueryHandler
{

    public function __construct(private UserRepository $repository)
    {
    }

    public function __invoke(ListUsersQuery $query): UsersResponse
    {
        $users = $this->repository->list($query->filtration());

        return UsersResponse::fromUsers($users);
    }
}
