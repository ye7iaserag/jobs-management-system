<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JMS\Job\Infrastructure\Persistence\Eloquent\JobModel;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Shared\Domain\Enum\Role;
use Shared\Infrastructure\Persistence\Eloquent\UserModel;
use Tests\TestCase;

class ListJobsTest extends TestCase
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
    public function test_get_jobs_list_returns_a_successful_response()
    {
        $user = UserModel::where('role', Role::Regular->value)->first();

        $token = JWTAuth::fromUser($user);

        $response = $this->get('api/jobs', ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200);
    }
}
