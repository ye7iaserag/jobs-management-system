<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Shared\Infrastructure\Exception\ValidationException;
use Shared\Infrastructure\Http\Resources\ErrorsResource;
use Tests\TestCase;

final class ValidationExceptionTest extends TestCase
{
    use WithFaker;

    function test_create_validation_exception()
    {
        $data = $this->faker->uuid();
        $validationException = new ValidationException([$data]);

        $array = $validationException->getValidationErrors();

        $this->assertEquals($array[0], $data);
    }

}
