<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'icon',
        'description',
        'badge',
        'is_highlight',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_highlight' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
