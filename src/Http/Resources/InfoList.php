<?php

namespace Coder\LaravelDash\Http\Resources;

use Coder\LaravelDash\Models\InfoList as ModelsInfoList;
use Illuminate\Http\Resources\Json\JsonResource;

class InfoList extends JsonResource
{
    protected $detail;

    public function __construct($resource, $detail = false)
    {
        parent::__construct($resource);
        $this->detail = $detail === true ?: false;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $return = [
            'id' => intval($this->id),
            'class_id' => intval($this->class_id),
            'class_name' => $this->infoClass->name,
            'title' => $this->title,
            'description' => $this->description,
            'picture' => $this->picture,
            'author' => $this->author,
            'source' => $this->source,
            'views' => intval($this->views),
            'is_show' => intval($this->is_show),
            'sort' => intval($this->sort),
            'release_at' => $this->release_at ? $this->release_at->timestamp : null,
            'maxSort' => ModelsInfoList::max('sort')
        ];

        if ($this->detail) {
            $return['pictures'] = $this->pictures;
            $return['link_url'] = $this->link_url;
            $return['keywords'] = $this->keywords;
            $return['content'] = $this->content;
            $return['files'] = File::collection($this->files);
        }

        return $return;
    }
}
