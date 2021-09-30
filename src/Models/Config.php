<?php

namespace Coder\LaravelDash\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value'];

    public function scopeGetValue($query, $key)
    {
        return $query->where('key', $key);
    }
}
