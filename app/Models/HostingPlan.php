<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'tagline',
        'monthly_price',
        'yearly_price',
        'badge',
        'features',
        'websites',
        'storage',
        'bandwidth',
        'cpu',
        'ram',
        'is_popular',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'is_popular' => 'boolean',
            'is_active' => 'boolean',
            'monthly_price' => 'integer',
            'yearly_price' => 'integer',
            'sort_order' => 'integer',
        ];
    }
}
