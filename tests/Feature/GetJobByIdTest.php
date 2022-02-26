<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JMS\Job\Infrastructure\Persistence\Eloquent\JobModel;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Shared\Infrastructure\Persistence\Eloquent\UserModel;
use Tests\TestCase;

class GetJobByIdTest extends TestCase
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
    public function test_get_job_by_id_returns_a_successful_response()
    {
        $job = JobModel::first();

        $user = UserModel::where('id', $job->user_id)->first();

        $token = JWTAuth::fromUser($user);

        $response = $this->get('api/jobs/'.$job->id, ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200);
    }
}
