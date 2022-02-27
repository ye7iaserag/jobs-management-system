<?php

declare(strict_types=1);

namespace JMS\Job\Application\ListJobs;

use Shared\Domain\Bus\Query\Query;
use JMS\Job\Domain\DTO\JobsFiltration;

final class ListJobsQuery implements Query
{
    public function __construct(private JobsFiltration $filtration)
    {
    }

    public function filtration(): JobsFiltration
    {
        return $this->filtration;
    }
}
