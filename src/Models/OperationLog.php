<?php

namespace Coder\LaravelDash\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'path', 'method', 'ip', 'sql',
        'params'
    ];
}
