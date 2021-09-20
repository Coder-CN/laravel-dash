<?php

namespace Coder\LaravelDash\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'nickname', 'username', 'mobile', 'email', 'avatar',
        'password', 'permissions', 'api_token', 'last_login_at'
    ];

    protected $casts = [
        'permissions' => 'array'
    ];

    protected $dates = [
        'last_login_at'
    ];

    public function operationLogs() {
        return $this->hasMany(OperationLog::class);
    }
}
