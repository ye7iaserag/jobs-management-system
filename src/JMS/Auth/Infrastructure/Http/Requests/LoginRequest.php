<?php

namespace JMS\Auth\Infrastructure\Http\Requests;


use Shared\Infrastructure\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest {
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => [
                'required',
                'email'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:32'
            ],
        ];
    }
}
