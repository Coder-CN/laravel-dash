<?php

namespace Coder\LaravelDash\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class File extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => intval($this->id),
            'type' => $this->type,
            'url' => $this->url,
            'time' => $this->created_at->toDateTimeString()
        ];
    }
}
