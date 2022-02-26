<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JMS\Job\Infrastructure\Persistence\Eloquent\JobModel;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Shared\Domain\Enum\Role;
use Shared\Infrastructure\Persistence\Eloquent\UserModel;
use Tests\TestCase;

class UpdateJobTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed = DatabaseSeeder::class;
        $this->refreshDatabase();
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_update_job_returns_a_successful_response()
    {
        $job = JobModel::first();

        $user = UserModel::where('id', $job->user_id)->first();

        $token = JWTAuth::fromUser($user);

        $response = $this->patch('api/jobs/'.$job->id, ['title' => 'test', 'description' => 'test'], ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200);
    }
}
