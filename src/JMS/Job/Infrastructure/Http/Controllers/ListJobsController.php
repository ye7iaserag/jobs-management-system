<?php

declare(strict_types=1);

namespace JMS\Job\Infrastructure\Http\Controllers;

use JMS\Job\Application\Response\JobsResponse;
use JMS\Job\Application\Query\ListJobs\ListJobsQuery;
use Shared\Domain\Bus\Query\QueryBus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use JMS\Job\Domain\DTO\JobsFiltration;
use JMS\Job\Domain\ValueObject\JobOwnerId;
use Shared\Domain\Port\AuthService;
use JMS\Job\Infrastructure\Http\Requests\ListJobsRequest;
use JMS\Job\Infrastructure\Http\Resources\ListJobsResource;
use Shared\Domain\Enum\Role;

final class ListJobsController
{
    public function __construct(private QueryBus $queryBus, private AuthService $AuthService)
    {
    }

    public function __invoke(ListJobsRequest $request): ListJobsResource
    {
        $identity = $this->AuthService->getIdentity();
        $jobOwner = null;
        if ($identity->role()->value() === Role::Regular) 
            $jobOwner = JobOwnerId::fromValue($identity->id()->value());
        
        $jobsResponse = $this->queryBus->ask(
            new ListJobsQuery(new JobsFiltration($jobOwner))
        );

        if (!$jobsResponse instanceof JobsResponse) throw new \Exception();

        return new ListJobsResource($jobsResponse);
    }
}
