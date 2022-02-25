<?php

/**
 * This is the parent of all requests
 * Extended by all requests to handle returning error messages when validations fail
 *
 * @author Yehia Serag
 */

namespace Shared\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Shared\Infrastructure\Exceptions\ValidationException;
use Shared\Infrastructure\Constants\Error;
use Shared\Infrastructure\Exceptions\AuthorizationException;

abstract class BaseRequest extends FormRequest
{

    /**
     * 
     * @param array $query
     * @param array $request
     * @param array $attributes
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param type $content
     */
    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    protected $authorizationService;

    /**
     * Authorization rules for the request
     * 
     * @return boolean
     */
    public function authorize()
    {
        throw new AuthorizationException(Error::UNAUTHORIZED_ACCESS);
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException(Error::INVALID_INPUTS); //, $validator->errors()->messages());
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException(Error::UNAUTHORIZED_ACCESS);
    }
}
