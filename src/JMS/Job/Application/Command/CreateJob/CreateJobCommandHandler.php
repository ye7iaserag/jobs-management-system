<?php

declare(strict_types=1);

namespace JMS\Job\Application\Command\CreateJob;

use JMS\Job\Domain\Entity\Job;
use JMS\Job\Domain\Exceptions\JobAlreadyExists;
use JMS\Job\Domain\ValueObject\{JobId, JobTitle, JobDescription, JobOwnerId};
use JMS\Job\Domain\Port\JobRepository;
use Shared\Domain\Bus\Command\CommandHandler;
use Shared\Domain\Bus\Event\EventBus;

final class CreateJobCommandHandler implements CommandHandler
{

    public function __construct(private JobRepository $repository, private EventBus $eventBus)
    {
    }

    public function __invoke(CreateJobCommand $command): void
    {
        $id = JobId::fromValue($command->id());
        $job = $this->repository->find($id);

        if (null !== $job) {
            throw new JobAlreadyExists();
        }

        $title = JobTitle::fromValue($command->title());
        $description = JobDescription::fromValue($command->description());
        $ownerId = JobOwnerId::fromValue($command->ownerId());

        $job = Job::make($id, $title, $description, $ownerId);

        $this->repository->save($job);

        array_map([$this->eventBus, 'publish'], $job->pullDomainEvents());
    }
}
