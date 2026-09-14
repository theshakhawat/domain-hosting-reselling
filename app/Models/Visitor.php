<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'session_id',
        'country',
        'country_code',
        'city',
        'isp',
        'device_type',
        'operating_system',
        'browser',
        'screen_resolution',
        'visited_route',
        'method',
        'referrer',
        'hits',
        'last_activity_at',
    ];

    protected function casts(): array
    {
        return [
            'hits' => 'integer',
            'last_activity_at' => 'datetime',
        ];
    }
}
