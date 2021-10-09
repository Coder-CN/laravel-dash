<?php

namespace Coder\LaravelDash\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Section extends JsonResource
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
            'name' => $this->name,
            'sub_title' => $this->sub_title,
            'parent_id' => intval($this->parent_id),
            'parent_name' => $this->parent_id ? $this->parent->name : null,
            'description' => $this->description,
            'picture' => $this->picture,
            'pictures' => $this->pictures,
            'link_url' => $this->link_url,
            'seo_title' => $this->seo_title,
            'keywords' => $this->keywords,
            'is_show' => intval($this->is_show),
            'sort' => intval($this->sort),
            'children' => self::collection($this->children()->orderBy('sort')->get())
        ];
    }
}
