<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class System extends Model
{
    use HasFactory;

    public const TARGETS = ['_self', '_blank'];

    protected $fillable = [
        'title',
        'slug',
        'description',
        'short_description',
        'icon',
        'image',
        'link',
        'category_id',
        'target',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public static function targetLabels(): array
    {
        return [
            '_self' => 'همان پنجره',
            '_blank' => 'پنجره جدید',
        ];
    }

    public function getTargetLabelAttribute(): string
    {
        return self::targetLabels()[$this->target] ?? $this->target;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
