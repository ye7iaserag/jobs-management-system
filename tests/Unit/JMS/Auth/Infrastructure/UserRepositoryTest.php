<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Auth\Infrastructure;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use JMS\Auth\Domain\Entity\User;
use JMS\Auth\Domain\DTO\UsersFiltration;
use JMS\Auth\Domain\ValueObject\UserEmail;
use JMS\Auth\Domain\ValueObject\UserPassword;
use JMS\Auth\Domain\ValueObject\UserRole;
use JMS\Auth\Infrastructure\Service\HashService;
use JMS\Auth\Infrastructure\Persistence\Eloquent\UserModel;
use JMS\Auth\Infrastructure\Persistence\Eloquent\UserRepository;
use Shared\Domain\Enum\Role;
use Tests\TestCase;

final class UserRepositoryTest extends TestCase
{
    use WithFaker;

    function test_user_repository_get_by_email()
    {
        $uuid = $this->faker->uuid();
        $email = $this->faker->email();
        $password = $this->faker->name();
        $role = Role::Regular->value;

        $userModel = new UserModel();
        $userModel->id = $uuid;
        $userModel->email = $email;
        $userModel->password = $password;
        $userModel->role = $role;

        $this->mock(Builder::class, fn ($mock) => $mock->shouldReceive('first')->once()->andReturn($userModel));
        $builder = $this->app->make(Builder::class);
        $this->mock(UserModel::class, fn ($mock) => $mock->shouldReceive('where')->once()->andReturn($builder));
        $model = $this->app->make(UserModel::class);

        $userRepository = new UserRepository($model);

        $user = $userRepository->findByEmail(new UserEmail($userModel->email));

        $this->assertEquals($uuid, $user->id()->value());
        $this->assertEquals($email, $user->email()->value());
        $this->assertEquals($password, $user->password()->value());
        $this->assertEquals($role, $user->role()->value()->value);
    }

    function test_user_repository_get_by_email_not_found()
    {
        $this->mock(Builder::class, fn ($mock) => $mock->shouldReceive('first')->once()->andReturn(null));
        $builder = $this->app->make(Builder::class);
        $this->mock(UserModel::class, fn ($mock) => $mock->shouldReceive('where')->once()->andReturn($builder));
        $model = $this->app->make(UserModel::class);

        $userRepository = new UserRepository($model);

        $user = $userRepository->findByEmail(new UserEmail($this->faker->email()));

        $this->assertNull($user);
    }

    function test_user_repository_list()
    {
        $uuid = $this->faker->uuid();
        $email = $this->faker->email();
        $password = $this->faker->name();
        $role = Role::Regular->value;

        $userModel = new UserModel();
        $userModel->id = $uuid;
        $userModel->email = $email;
        $userModel->password = $password;
        $userModel->role = $role;

        $this->mock(UserModel::class, fn ($mock) => $mock->shouldReceive('get')->once()->andReturn(new Collection([$userModel])));
        $model = $this->app->make(UserModel::class);

        $userRepository = new UserRepository($model);

        $users = $userRepository->list(new UsersFiltration(null));
        $users = $users->all();

        $this->assertEquals($uuid, $users[0]->id()->value());
        $this->assertEquals($email, $users[0]->email()->value());
        $this->assertEquals($password, $users[0]->password()->value());
        $this->assertEquals($role, $users[0]->role()->value()->value);
    }

    function test_user_repository_list_with_filtration()
    {
        $uuid = $this->faker->uuid();
        $email = $this->faker->email();
        $password = $this->faker->name();
        $role = Role::Regular->value;

        $userModel = new UserModel();
        $userModel->id = $uuid;
        $userModel->email = $email;
        $userModel->password = $password;
        $userModel->role = $role;

        $this->mock(Builder::class, fn ($mock) => $mock->shouldReceive('get')->once()->andReturn(new Collection([$userModel])));
        $builder = $this->app->make(Builder::class);
        $this->mock(UserModel::class, fn ($mock) => $mock->shouldReceive('where')->once()->andReturn($builder));
        $model = $this->app->make(UserModel::class);

        $userRepository = new UserRepository($model);

        $users = $userRepository->list(new UsersFiltration(new UserRole(Role::Manager)));
        $users = $users->all();

        $this->assertEquals($uuid, $users[0]->id()->value());
        $this->assertEquals($email, $users[0]->email()->value());
        $this->assertEquals($password, $users[0]->password()->value());
        $this->assertEquals($role, $users[0]->role()->value()->value);
    }

}
