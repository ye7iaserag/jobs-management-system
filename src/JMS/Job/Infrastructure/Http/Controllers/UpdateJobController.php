<?php

declare(strict_types=1);

namespace JMS\Job\Infrastructure\Http\Controllers;

use Exception;
use JMS\Job\Application\UpdateJob\UpdateJobCommand;
use Shared\Domain\Bus\Command\CommandBus;
use JMS\Job\Infrastructure\Http\Requests\UpdateJobRequest;
use Shared\Domain\Bus\Query\QueryBus;
use JMS\Job\Application\GetJob\GetJobByIdQuery;
use JMS\Job\Application\Response\JobResponse;
use JMS\Job\Infrastructure\Http\Resources\UpdateJobResource;
use Shared\Domain\Port\AuthService;
use Shared\Infrastructure\Exception\AuthorizationException;
use Shared\Domain\Enum\Role;

final class UpdateJobController
{
    public function __construct(
        private CommandBus $commandBus,
        private QueryBus $queryBus,
        private AuthService $AuthService
    ) {
    }

    public function __invoke(UpdateJobRequest $request, string $id): UpdateJobResource
    {
        $jobResponse = $this->queryBus->ask(
            new GetJobByIdQuery($id)
        );

        if (!$jobResponse instanceof JobResponse) throw new Exception();

        $identity = $this->AuthService->getIdentity();
        if ($identity->id()->value() !== $jobResponse->ownerId() && $identity->role()->value() !== Role::Manager)
            throw new AuthorizationException();

        $this->commandBus->dispatch(
            new UpdateJobCommand(
                $id,
                $request->get('title'),
                $request->get('description')
            )
        );

        return new UpdateJobResource(['id' => $id]);
    }
}
