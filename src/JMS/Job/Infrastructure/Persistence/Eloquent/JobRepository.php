<?php

declare(strict_types=1);

namespace JMS\Job\Infrastructure\Persistence\Eloquent;

use JMS\Job\Domain\Entity\Job;
use JMS\Job\Domain\ValueObject\JobId;
use JMS\Job\Domain\Exceptions\JobAlreadyExists;
use JMS\Job\Domain\Port\JobRepository as JobRepositoryInterface;
use JMS\Job\Domain\DTO\Jobs;
use Shared\Infrastructure\Persistence\Eloquent\EloquentException;
use Exception;
use JMS\Job\Domain\Entity\JobOwner;
use JMS\Job\Domain\Exceptions\JobNotFound;
use JMS\Job\Domain\DTO\JobsFiltration;

final class JobRepository implements JobRepositoryInterface
{
    private JobModel $model;

    public function __construct(JobModel $model)
    {
        $this->model = $model;
    }

    /**
     * @throws JobNotFound
     */
    public function delete(JobId $id): void
    {
        $job = $this->model->find($id->value());

        if (null === $job) {
            throw new JobNotFound();
        }

        $job->delete();
    }

    public function find(JobId $id): ?Job
    {
        $eloquentJob = $this->model->with('owner')->where('id', $id->value())->first();

        if (null === $eloquentJob) {
            return null;
        }

        return $this->toDomain($eloquentJob);
    }

    private function toDomain(JobModel $eloquentJobModel): Job
    {
        return Job::fromPrimitives(
            $eloquentJobModel->id,
            $eloquentJobModel->title,
            $eloquentJobModel->description,
            $eloquentJobModel->user_id,
            JobOwner::fromPrimitives(
                $eloquentJobModel->owner->id,
                $eloquentJobModel->owner->name
            )
        );
    }

    public function list(JobsFiltration $filtration): Jobs
    {
        $eloquentJobs = $this->model->with('owner');
        
        if($filtration->ownerId())
            $eloquentJobs->where('user_id', $filtration->ownerId()->value());
        
        $result = $eloquentJobs->get();

        $jobs = $result->map(
            function (JobModel $eloquentJob) {
                return $this->toDomain($eloquentJob);
            }
        )->toArray();

        return new Jobs($jobs);
    }

    /**
     * @throws EloquentException
     */
    public function save(Job $job): void
    {
        $jobModel = $this->model->find($job->id()->value());

        if (null === $jobModel) {
            $jobModel = $this->model;
            $jobModel->id = $job->id()->value();
        }

        $jobModel->title = $job->title()->value();
        $jobModel->description = $job->description()->value();
        $jobModel->user_id = $job->ownerId()->value();

        try {
            $jobModel->save();
        } catch (Exception $e) {
            throw new EloquentException(
                $e->getMessage(),
                null,
                $e->getPrevious()
            );
        }
    }
}
