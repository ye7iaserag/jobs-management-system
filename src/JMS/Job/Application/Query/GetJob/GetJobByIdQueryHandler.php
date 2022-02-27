<?php

declare(strict_types=1);

namespace JMS\Job\Application\Query\GetJob;

use JMS\Job\Application\Response\JobResponse;
use JMS\Job\Domain\ValueObject\JobId;
use JMS\Job\Domain\Exceptions\JobNotFound;
use JMS\Job\Domain\Port\JobRepository;
use Shared\Domain\Bus\Query\QueryHandler;

final class GetJobByIdQueryHandler implements QueryHandler
{
    private JobRepository $repository;

    public function __construct(JobRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetJobByIdQuery $query): JobResponse
    {
        $id = JobId::fromValue($query->id());
        $job = $this->repository->find($id);

        if (null === $job) {
            throw new JobNotFound();
        }

        return JobResponse::fromJob($job);
    }
}
