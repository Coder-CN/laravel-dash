<?php

namespace Coder\LaravelDash\Http\Resources;

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
        if ($this->pivot) {
            return [
                'id' => intval($this->id),
                'url' => $this->url,
                'title' => $this->pivot->title,
                'info' => json_decode($this->pivot->info),
                'expiration_at' => $this->pivot->expiration_at ? strtotime($this->pivot->expiration_at) : null
            ];
        } else {
            return [
                'id' => intval($this->id),
                'type' => $this->type,
                'url' => $this->url,
                'time' => $this->created_at->toDateTimeString()
            ];
        }
    }
}
