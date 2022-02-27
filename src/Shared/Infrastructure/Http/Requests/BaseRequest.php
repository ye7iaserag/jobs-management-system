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
use Shared\Infrastructure\Exception\ValidationException;
use Shared\Infrastructure\Constant\Error;
use Shared\Infrastructure\Exception\AuthorizationException;

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
        throw new AuthorizationException();
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator->errors()->messages()); //, $validator->errors()->messages());
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws AuthorizationException
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException();
    }
}
