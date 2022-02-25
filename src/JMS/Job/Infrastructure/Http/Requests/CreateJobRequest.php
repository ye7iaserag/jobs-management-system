<?php

namespace JMS\Job\Infrastructure\Http\Requests;


use Shared\Infrastructure\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class CreateJobRequest extends BaseRequest {
    
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
            'title' => [
                'required',
                'string',
                'min:1',
                'max:100'
            ],
            'description' => [
                'required',
                'string',
                'min:1',
                'max:500'
            ],
        ];
    }
}
