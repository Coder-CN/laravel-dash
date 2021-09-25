<?php

namespace Coder\LaravelDash\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Banner extends JsonResource
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
            'location' => $this->location,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'picture' => $this->picture,
            'link_url' => $this->link_url,
            'is_show' => boolval($this->is_show),
            'sort' => intval($this->sort)
        ];
    }
}
