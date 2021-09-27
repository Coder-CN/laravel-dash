<?php

namespace Coder\LaravelDash\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InfoList extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'class_id', 'title', 'description', 'picture',
        'pictures', 'link_url', 'keywords', 'content',
        'author', 'source', 'views', 'is_show', 'sort',
        'release_at'
    ];

    protected $casts = [
        'pictures' => 'array'
    ];

    protected $dates = ['release_at'];

    public function scopeFilter($query, $params)
    {
        foreach ($params as $key => $value) {
            if ($key === 'content' && $value) {
                $query->where(function ($query) use ($value) {
                    $query->where('id', $value)->orWhere('title', 'like', '%' . $value . '%')
                        ->orWhere('description', 'like', '%' . $value . '%')
                        ->orWhere('author', $value)
                        ->orWhere('source', $value);
                });
            } else if ($key === 'release_at' && is_array($value)) {
                $query->where('release_at', '>=', $value[0])->where('release_at', '<=', $value[1]);
            }
        }

        return $query;
    }

    public function scopeClass($query, $class_id)
    {
        return $query->where('class_id', $class_id);
    }

    public function infoClass()
    {
        return $this->belongsTo(InfoClass::class, 'class_id');
    }

    public function files()
    {
        return $this->morphToMany(File::class, 'fileable')->withPivot(['title', 'info', 'expiration_at']);
    }
}
