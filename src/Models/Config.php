<?php

namespace Coder\LaravelDash\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value'];

    public static function getValue($key)
    {
        $result = self::where('key', $key)->first();
        return $result ? $result->value : null;
    }
}
