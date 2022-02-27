<?php

declare(strict_types=1);

namespace JMS\Job\Application\DeleteJob;

use JMS\Job\Domain\ValueObject\JobId;
use JMS\Job\Domain\Exceptions\JobNotFound;
use JMS\Job\Domain\Port\JobRepository;
use Shared\Domain\Bus\Command\CommandHandler;

final class DeleteJobByIdCommandHandler implements CommandHandler
{
    private JobRepository $repository;

    public function __construct(JobRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DeleteJobByIdCommand $command): void
    {
        $id = JobId::fromValue($command->id());
        $job = $this->repository->find($id);

        if (null === $job) {
            throw new JobNotFound();
        }

        $this->repository->delete($id);
    }
}
