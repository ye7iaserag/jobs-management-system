<?php

namespace JMS\Auth\Infrastructure\Http\Resources;

use JMS\Auth\Application\LoginResponse;
use Shared\Infrastructure\Http\Resources\BaseJsonResource;

class LoginResource extends BaseJsonResource
{

    public function __construct(LoginResponse $response)
    {
        parent::__construct($response);
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
