<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Shared\Infrastructure\Exceptions\AuthorizationException;
use Shared\Infrastructure\Exceptions\ValidationException;
use Illuminate\Support\Facades\Validator;
use Shared\Infrastructure\Http\Requests\BaseRequest;

final class BaseRequestTest extends TestCase
{
    use WithFaker;

    function test_base_request_authorize()
    {
        $request = (new class extends BaseRequest
        {
            public function this()
            {
                return $this;
            }
        })->this();

        $this->expectException(AuthorizationException::class);

        $request->authorize();
    }

    function test_base_request_failed_validation()
    {
        $this->expectException(ValidationException::class);

        $validator = Validator::make([], []);

        (new class($validator) extends BaseRequest
        {
            public function __construct(protected $validator)
            {
                
            }
            public function failedValidationTest()
            {
                return $this->failedValidation($this->validator);
            }
        })->failedValidationTest();
    }

    function test_base_request_failed_authorization()
    {
        $this->expectException(AuthorizationException::class);

        (new class extends BaseRequest
        {
            public function failedAuthorizationTest()
            {
                return $this->failedAuthorization();
            }
        })->failedAuthorizationTest();
    }
}
