<?php

namespace JMS\Job\Domain\Port;

use JMS\Job\Domain\Entity\Job;
use JMS\Job\Domain\DTO\Jobs;
use JMS\Job\Domain\ValueObject\JobId;
use JMS\Job\Domain\DTO\JobsFiltration;

interface JobRepository
{
    public function delete(JobId $id): void;

    public function find(JobId $id): ?Job;

    public function list(JobsFiltration $filtration): Jobs;

    public function save(Job $job): void;
}
