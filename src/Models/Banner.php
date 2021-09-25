<?php

namespace Coder\LaravelDash\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'location', 'title', 'subtitle', 'picture',
        'link_url', 'is_show', 'sort'
    ];

    public function scopeShow($query)
    {
        return $query->where('is_show', true);
    }

    public function scopeLocation($query, $location)
    {
        return $query->where('location', $location);
    }
}
