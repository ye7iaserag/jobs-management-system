<?php

namespace JMS\Job\Infrastructure\Http\Resources;

use JMS\Job\Application\Response\JobResponse;
use Shared\Infrastructure\Http\Resources\BaseJsonResource;

class GetJobByIdResource extends BaseJsonResource
{
    public function __construct(JobResponse $response)
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
