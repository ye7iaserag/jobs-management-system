<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Shared\Domain\Enum\Role;
use Shared\Infrastructure\Persistence\Eloquent\UserModel;
use Tests\TestCase;

class CreateJobTest extends TestCase
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
    public function test_create_job_returns_a_successful_response()
    {
        $user = UserModel::where('role', Role::Regular->value)->first();

        $token = JWTAuth::fromUser($user);

        $response = $this->post('api/jobs', ['title' => 'test', 'description' => 'test'], ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200);
    }
}
