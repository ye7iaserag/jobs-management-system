<?php

namespace JMS\Auth\Application\Subscriber;

use Shared\Domain\Enum\Role;
use JMS\Auth\Application\ListUsers\ListUsersQuery;
use JMS\Auth\Application\Response\UsersResponse;
use JMS\Auth\Domain\DTO\UsersFiltration;
use JMS\Auth\Domain\ValueObject\UserRole;
use Shared\Domain\Bus\Event\DomainEventSubscriber;
use JMS\Job\Domain\Event\JobCreated;
use Shared\Domain\Bus\Event\EventBus;
use Shared\Domain\Bus\Query\QueryBus;

use JMS\Auth\Domain\Event\NotifyManagersJobCreated;

class JobCreatedSubscriber implements DomainEventSubscriber
{

    public function __construct(private QueryBus $queryBus, private EventBus $eventBus)
    {
    }

    public static function subscribedTo(): array
    {
        return [JobCreated::class];
    }

    public function __invoke(JobCreated $event): void
    {
        $response = $this->queryBus->ask(new ListUsersQuery(new UsersFiltration(UserRole::fromValue(Role::Manager->value))));
        $emails = [];

        if ($response instanceof UsersResponse)
            $emails = array_map(
                function ($user) {
                    return $user['email'];
                },
                $response->toArray()
            );

        if (count($emails) > 0)
            $this->eventBus->publish(new NotifyManagersJobCreated($event->aggregateId(), $emails));
    }
}
