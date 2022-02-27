<?php

declare(strict_types=1);

namespace JMS\Job\Infrastructure\Http\Controllers;

use JMS\Job\Application\Command\CreateJob\CreateJobCommand;
use Shared\Domain\Bus\Command\CommandBus;
use Shared\Domain\Port\UuidGenerator;
use Shared\Domain\Port\AuthService;
use JMS\Job\Infrastructure\Http\Requests\CreateJobRequest;
use JMS\Job\Infrastructure\Http\Resources\CreateJobResource;

final class CreateJobController
{
    public function __construct(
        private CommandBus    $commandBus,
        private UuidGenerator $uuidGenerator,
        private AuthService $AuthService
    ) {
    }

    public function __invoke(CreateJobRequest $request): CreateJobResource
    {
        $id = $this->uuidGenerator->generate();

        $this->commandBus->dispatch(
            new CreateJobCommand(
                $id,
                $request->get('title'),
                $request->get('description'),
                $this->AuthService->getIdentity()->id()->value()
            )
        );

        return new CreateJobResource(['id'=> $id]);
    }
}