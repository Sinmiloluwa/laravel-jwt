<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'email',
        'ip_address',
        'method',
        'url',
        'created_at',
    ];
}
