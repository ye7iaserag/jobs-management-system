<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Job\Domain\ValueObject\JobId;
use Tests\TestCase;
use JMS\Job\Infrastructure\Persistence\Eloquent\JobModel;
use Illuminate\Database\Eloquent\Collection;
use JMS\Job\Infrastructure\Persistence\Eloquent\JobRepository;
use Illuminate\Database\Eloquent\Builder;
use JMS\Job\Domain\Entity\Job;
use JMS\Job\Domain\Exceptions\JobNotFound;
use JMS\Job\Domain\DTO\JobsFiltration;
use JMS\Job\Domain\ValueObject\JobOwnerId;
use Shared\Infrastructure\Persistence\Eloquent\EloquentException;
use Shared\Infrastructure\Persistence\Eloquent\UserModel;

final class JobRepositoryTest extends TestCase
{
    use WithFaker;

    function test_job_repository_find()
    {
        $uuid = $this->faker->uuid();
        $title = $this->faker->name();
        $description = $this->faker->name();
        $ownerId = $this->faker->uuid();
        $ownerName = $this->faker->uuid();

        $jobModel = new JobModel();
        $jobModel->id = $uuid;
        $jobModel->title = $title;
        $jobModel->description = $description;
        $jobModel->user_id = $ownerId;
        $jobModel->owner = new UserModel();
        $jobModel->owner->id = $ownerId;
        $jobModel->owner->name = $ownerName;

        $this->mock(Builder::class, fn ($mock) => $mock->shouldReceive('where')->once()->andReturn($mock)->shouldReceive('first')->once()->andReturn($jobModel));
        $builder = $this->app->make(Builder::class);
        $this->mock(JobModel::class, fn ($mock) => $mock->shouldReceive('with')->once()->andReturn($builder));
        $model = $this->app->make(JobModel::class);
        $jobRepository = new JobRepository($model);

        $job = $jobRepository->find(new JobId($uuid));

        $this->assertEquals($uuid, $job->id()->value());
        $this->assertEquals($title, $job->title()->value());
        $this->assertEquals($description, $job->description()->value());
        $this->assertEquals($ownerId, $job->ownerId()->value());
        $this->assertEquals($ownerId, $job->owner()->id()->value());
        $this->assertEquals($ownerName, $job->owner()->name()->value());
    }

    function test_job_repository_find_unexisting_job()
    {
        $uuid = $this->faker->uuid();

        $this->mock(Builder::class, fn ($mock) => $mock->shouldReceive('where')->once()->andReturn($mock)->shouldReceive('first')->once()->andReturn(null));
        $builder = $this->app->make(Builder::class);
        $this->mock(JobModel::class, fn ($mock) => $mock->shouldReceive('with')->once()->andReturn($builder));
        $model = $this->app->make(JobModel::class);
        $jobRepository = new JobRepository($model);

        $job = $jobRepository->find(new JobId($uuid));

        $this->assertNull($job);
    }

    function test_job_repository_delete()
    {
        $uuid = $this->faker->uuid();

        $jobModel = new JobModel();
        $jobModel->id = $uuid;
        $jobModel->title = $this->faker->name();
        $jobModel->description = $this->faker->name();
        $jobModel->user_id = $this->faker->uuid();

        $this->mock(JobModel::class, fn ($mock) => $mock->shouldReceive('find')->once()->andReturn($jobModel));
        $model = $this->app->make(JobModel::class);
        $jobRepository = new JobRepository($model);

        $jobRepository->delete(new JobId($uuid));
    }

    function test_job_repository_delete_unexisting_job()
    {
        $uuid = $this->faker->uuid();
        $this->expectException(JobNotFound::class);

        $this->mock(JobModel::class, fn ($mock) => $mock->shouldReceive('find')->once()->andReturn(null));
        $model = $this->app->make(JobModel::class);
        $jobRepository = new JobRepository($model);

        $jobRepository->delete(new JobId($uuid));
    }

    function test_job_repository_list()
    {
        $uuid = $this->faker->uuid();
        $title = $this->faker->name();
        $description = $this->faker->name();
        $ownerId = $this->faker->uuid();
        $ownerName = $this->faker->uuid();

        $jobModel = new JobModel();
        $jobModel->id = $uuid;
        $jobModel->title = $title;
        $jobModel->description = $description;
        $jobModel->user_id = $ownerId;
        $jobModel->owner = new UserModel();
        $jobModel->owner->id = $ownerId;
        $jobModel->owner->name = $ownerName;

        $collection = new Collection([$jobModel]);

        $this->mock(Builder::class, fn ($mock) => $mock->shouldReceive('get')->once()->andReturn($collection));
        $builder = $this->app->make(Builder::class);
        $this->mock(JobModel::class, fn ($mock) => $mock->shouldReceive('with')->once()->andReturn($builder));
        $model = $this->app->make(JobModel::class);
        $jobRepository = new JobRepository($model);

        $response = $jobRepository->list(new JobsFiltration(null));

        $response = $response->all();

        $this->assertEquals($uuid, $response[0]->id()->value());
        $this->assertEquals($title, $response[0]->title()->value());
        $this->assertEquals($description, $response[0]->description()->value());
        $this->assertEquals($ownerId, $response[0]->ownerId()->value());
        $this->assertEquals($ownerId, $response[0]->owner()->id()->value());
        $this->assertEquals($ownerName, $response[0]->owner()->name()->value());
    }

    function test_job_repository_list_with_filtration()
    {
        $uuid = $this->faker->uuid();
        $title = $this->faker->name();
        $description = $this->faker->name();
        $ownerId = $this->faker->uuid();
        $ownerName = $this->faker->uuid();

        $jobModel = new JobModel();
        $jobModel->id = $uuid;
        $jobModel->title = $title;
        $jobModel->description = $description;
        $jobModel->user_id = $ownerId;
        $jobModel->owner = new UserModel();
        $jobModel->owner->id = $ownerId;
        $jobModel->owner->name = $ownerName;

        $collection = new Collection([$jobModel]);

        $this->mock(Builder::class, fn ($mock) => $mock->shouldReceive('where')->once()->andReturn($mock)->shouldReceive('get')->once()->andReturn($collection));
        $builder = $this->app->make(Builder::class);
        $this->mock(JobModel::class, fn ($mock) => $mock->shouldReceive('with')->once()->andReturn($builder));
        $model = $this->app->make(JobModel::class);
        $jobRepository = new JobRepository($model);

        $response = $jobRepository->list(new JobsFiltration(new JobOwnerId($ownerId)));

        $response = $response->all();

        $this->assertEquals($uuid, $response[0]->id()->value());
        $this->assertEquals($title, $response[0]->title()->value());
        $this->assertEquals($description, $response[0]->description()->value());
        $this->assertEquals($ownerId, $response[0]->ownerId()->value());
        $this->assertEquals($ownerId, $response[0]->owner()->id()->value());
        $this->assertEquals($ownerName, $response[0]->owner()->name()->value());
    }


    function test_job_repository_save_new_entity()
    {
        $uuid = $this->faker->uuid();
        $title = $this->faker->name();
        $description = $this->faker->name();
        $ownerId = $this->faker->uuid();

        $jobModel = new JobModel();
        $jobModel->id = $uuid;
        $jobModel->title = $title;
        $jobModel->description = $description;
        $jobModel->user_id = $ownerId;

        $modelMock = $this->mock(JobModel::class, fn ($mock) => $mock->shouldReceive('setAttribute')->shouldReceive('save')->once()->andReturn($mock));

        $job = Job::fromPrimitives($uuid, $title, $description, $ownerId);

        $this->mock(JobModel::class, fn ($mock) => $mock->shouldReceive('find')->once()->andReturn($modelMock));
        $model = $this->app->make(JobModel::class);
        $jobRepository = new JobRepository($model);

        $jobRepository->save($job);
    }

    function test_job_repository_save_existing_entity()
    {
        $job = Job::fromPrimitives($this->faker->uuid(), $this->faker->name(), $this->faker->name(), $this->faker->uuid());

        $this->mock(JobModel::class, fn ($mock) => $mock->shouldReceive('find')->once()->andReturn(null)->shouldReceive('setAttribute')->shouldReceive('save'));
        $model = $this->app->make(JobModel::class);
        $jobRepository = new JobRepository($model);

        $jobRepository->save($job);
    }

    function test_job_repository_save_exception()
    {
        $job = Job::fromPrimitives($this->faker->uuid(), $this->faker->name(), $this->faker->name(), $this->faker->uuid());

        $this->mock(JobModel::class, fn ($mock) => $mock->shouldReceive('find')->once()->andReturn(null)->shouldReceive('setAttribute')->shouldReceive('save')->andThrow(new \Exception()));
        
        $this->expectException(EloquentException::class);

        $model = $this->app->make(JobModel::class);
        $jobRepository = new JobRepository($model);

        $jobRepository->save($job);
    }


}
