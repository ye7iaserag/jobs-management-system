<?php

declare(strict_types=1);

namespace JMS\Job\Infrastructure\Http\Controllers;

use JMS\Job\Application\Command\DeleteJob\DeleteJobByIdCommand;
use Shared\Domain\Bus\Command\CommandBus;
use JMS\Job\Infrastructure\Http\Requests\DeleteJobRequest;
use Shared\Domain\Bus\Query\QueryBus;
use JMS\Job\Application\Query\GetJob\GetJobByIdQuery;
use JMS\Job\Application\Response\JobResponse;
use JMS\Job\Infrastructure\Http\Resources\DeleteJobResource;
use Shared\Domain\Port\AuthService;
use Shared\Infrastructure\Exception\AuthorizationException;
use Shared\Domain\Enum\Role;

final class DeleteJobController
{
    public function __construct(
        private CommandBus $commandBus,
        private QueryBus $queryBus,
        private AuthService $AuthService
    ) {
    }

    public function __invoke(DeleteJobRequest $request, string $id): DeleteJobResource
    {
        $jobResponse = $this->queryBus->ask(
            new GetJobByIdQuery($id)
        );

        if (!$jobResponse instanceof JobResponse) throw new \Exception();

        $identity = $this->AuthService->getIdentity();
        if ($identity->id()->value() !== $jobResponse->ownerId() && $identity->role()->value() !== Role::Manager)
            throw new AuthorizationException();

        $this->commandBus->dispatch(
            new DeleteJobByIdCommand($id)
        );

        return new DeleteJobResource([true]);
    }
}
