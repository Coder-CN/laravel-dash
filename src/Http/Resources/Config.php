<?php

namespace Coder\LaravelDash\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Config extends JsonResource
{
    protected $json = [
        'web_description',
        'web_keywords',
        'web_name',
        'web_seotitle'
    ];

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'key' => $this->key,
            'value' => in_array($this->key, $this->json) ? json_decode($this->value) : $this->value
        ];
    }
}
