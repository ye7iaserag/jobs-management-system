<?php

namespace JMS\Job\Infrastructure\Http\Resources;

use Shared\Infrastructure\Http\Resources\BaseJsonResource;

class CreateJobResource extends BaseJsonResource
{
    public function __construct(array $response)
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
