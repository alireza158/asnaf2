<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MarketPrice extends Model
{
    protected $fillable = [
        'key',
        'title',
        'category',
        'price',
        'change_amount',
        'change_percent',
        'currency',
        'unit',
        'source_name',
        'source_url',
        'fetched_at',
        'is_active',
        'sort_order',
        'raw_data',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'change_amount' => 'decimal:2',
        'change_percent' => 'decimal:2',
        'fetched_at' => 'datetime',
        'is_active' => 'boolean',
        'raw_data' => 'array',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
