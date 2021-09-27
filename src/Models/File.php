<?php

namespace Coder\LaravelDash\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'url'];

    public function scopeFilter($query, $params)
    {
        foreach ($params as $key => $value) {
            if ($key === 'types' && is_array($value) && count($value) > 0) {
                $query->whereIn('type', $value);
            }
        }

        return $query;
    }

    public function infoLists()
    {
        return $this->morphedByMany(InfoList::class, 'fileable');
    }
}
