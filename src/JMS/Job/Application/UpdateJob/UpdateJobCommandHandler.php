<?php

declare(strict_types=1);

namespace JMS\Job\Application\UpdateJob;

use JMS\Job\Domain\Entity\Job;
use JMS\Job\Domain\Entity\JobOwner;
use JMS\Job\Domain\ValueObject\{JobId, JobTitle, JobDescription};
use JMS\Job\Domain\Exceptions\JobNotFound;
use JMS\Job\Domain\Port\JobRepository;
use Shared\Domain\Bus\Command\CommandHandler;

final class UpdateJobCommandHandler implements CommandHandler
{
    private JobRepository $repository;

    public function __construct(JobRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UpdateJobCommand $command): void
    {
        $id = JobId::fromValue($command->id());
        $job = $this->repository->find($id);

        if (null === $job) {
            throw new JobNotFound();
        }

        $title = JobTitle::fromValue($command->title());
        $description = JobDescription::fromValue($command->description());

        $job->modify($title, $description);

        $this->repository->save($job);
    }
}
