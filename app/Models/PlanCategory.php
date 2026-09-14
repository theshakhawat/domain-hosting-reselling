<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlanCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'badge',
        'tagline',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Get all hosting plans associated with this category slug.
     */
    public function plans(): HasMany
    {
        return $this->hasMany(HostingPlan::class, 'category', 'slug');
    }
}
