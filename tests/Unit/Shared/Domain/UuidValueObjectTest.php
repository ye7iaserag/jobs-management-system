<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Domain;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Shared\Domain\ValueObject\UuidValueObject;

final class UuidValueObjectTest extends TestCase
{
    use WithFaker;

    function test_create_uuid_value_object()
    {
        $id = $this->faker->uuid();
        $idValueObject = new UuidValueObject($id);

        $this->assertEquals($id, $idValueObject->value());
    }

    function test_hydrate_uuid_value_object()
    {
        $id = $this->faker->uuid();
        $idValueObject = UuidValueObject::fromValue($id);

        $this->assertEquals($id, $idValueObject->value());
    }

    function test_random_uuid_value_object()
    {
        $idValueObject = UuidValueObject::random();

        $this->assertNotNull($idValueObject->value());
    }

    function test_uuid_value_object_equals()
    {
        $id = $this->faker->uuid();
        $idValueObject = UuidValueObject::fromValue($id);

        $otherIdValueObject = UuidValueObject::fromValue($id);

        $this->assertTrue($idValueObject->equals($otherIdValueObject));
    }

    function test_invalid_uuid_value_object()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        $id = $this->faker->name();
        UuidValueObject::fromValue($id);
    }
    
}
