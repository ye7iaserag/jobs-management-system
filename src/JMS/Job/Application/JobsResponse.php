<?php

declare(strict_types=1);

namespace JMS\Job\Application;

use JMS\Job\Domain\Jobs;
use Shared\Domain\Bus\Query\Response;

final class JobsResponse implements Response
{
    /** @var array<JobResponse> */
    private array $jobs;

    public function __construct(array $jobs)
    {
        $this->jobs = $jobs;
    }

    public static function fromJobs(Jobs $jobs): self
    {
        $jobResponses = array_map(
            function ($job) {
                return JobResponse::fromJob($job);
            },
            $jobs->all()
        );

        return new self($jobResponses);
    }

    public function toArray(): array
    {
        return array_map(function (JobResponse $jobResponse) {
            return $jobResponse->toArray();
        }, $this->jobs);
    }
}
