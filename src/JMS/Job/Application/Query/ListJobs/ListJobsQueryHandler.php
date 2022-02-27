<?php

declare(strict_types=1);

namespace JMS\Job\Application\Query\ListJobs;

use JMS\Job\Application\Response\JobsResponse;
use JMS\Job\Domain\Port\JobRepository;
use Shared\Domain\Bus\Query\QueryHandler;

final class ListJobsQueryHandler implements QueryHandler
{
    public function __construct(private JobRepository $repository)
    {
    }

    public function __invoke(ListJobsQuery $query): JobsResponse
    {
        $jobs = $this->repository->list($query->filtration());

        return JobsResponse::fromJobs($jobs);
    }
}
