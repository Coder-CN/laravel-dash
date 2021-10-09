<?php

namespace Coder\LaravelDash\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InfoClass extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'parent_id', 'description', 'picture',
        'pictures', 'link_url', 'seo_title', 'keywords',
        'is_show', 'sort', 'diy_content', 'sub_title'
    ];

    protected $casts = [
        'pictures' => 'array',
        'diy_content' => 'array'
    ];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function infoLists()
    {
        return $this->hasMany(InfoList::class, 'class_id');
    }
}
