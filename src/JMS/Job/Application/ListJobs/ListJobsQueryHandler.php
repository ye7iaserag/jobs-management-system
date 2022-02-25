<?php

declare(strict_types=1);

namespace JMS\Job\Application\ListJobs;

use JMS\Job\Application\JobsResponse;
use JMS\Job\Domain\JobRepository;
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
