<?php

declare(strict_types=1);

namespace JMS\Job\Infrastructure\Http\Controllers;

use JMS\Job\Application\Query\GetJob\GetJobByIdQuery;
use Shared\Domain\Bus\Query\QueryBus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Shared\Infrastructure\Exception\AuthorizationException;
use JMS\Job\Infrastructure\Http\Requests\GetJobByIdRequest;
use JMS\Job\Application\Response\JobResponse;
use JMS\Job\Infrastructure\Http\Resources\GetJobByIdResource;
use Shared\Domain\Port\AuthService;
use Shared\Domain\Enum\Role;

final class GetJobByIdController
{
    public function __construct(
        private QueryBus    $queryBus,
        private AuthService $AuthService
    ) {
    }

    public function __invoke(GetJobByIdRequest $request, string $id): GetJobByIdResource
    {
        $jobResponse = $this->queryBus->ask(
            new GetJobByIdQuery($id)
        );

        if (!$jobResponse instanceof JobResponse) throw new \Exception();

        $identity = $this->AuthService->getIdentity();
        if ($identity->id()->value() !== $jobResponse->ownerId() && $identity->role()->value() !== Role::Manager)
            throw new AuthorizationException();

        return new GetJobByIdResource($jobResponse);
    }
}
