<?php

namespace Coder\LaravelDash\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id', 'path', 'method', 'ip', 'sql',
        'params'
    ];

    protected $casts = [
        'params' => 'array'
    ];

    public function admin() {
        return $this->belongsTo(Admin::class);
    }
}
