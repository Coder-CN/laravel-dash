<?php

namespace Coder\LaravelDash\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Fileable extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'file_id', 'fileable_id', 'fileable_type',
        'title', 'info', 'expiration_at'
    ];

    protected $dates = ['expiration_at'];
}
