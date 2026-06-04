<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Route;
use Throwable;

class MenuItem extends Model
{
    use HasFactory;

    public const TYPES = ['custom', 'page', 'post', 'union', 'tourism', 'gallery', 'video', 'system', 'service'];
    public const TARGETS = ['_self', '_blank'];

    protected $fillable = [
        'menu_id',
        'parent_id',
        'title',
        'type',
        'url',
        'route_name',
        'reference_type',
        'reference_id',
        'target',
        'icon',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'reference_id' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->with('children');
    }

    public function adminChildren(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->with('adminChildren');
    }

    public function getResolvedUrlAttribute(): string
    {
        if ($this->route_name && Route::has($this->route_name)) {
            try {
                return route($this->route_name);
            } catch (Throwable) {
                return $this->url ?: '#';
            }
        }

        return $this->url ?: '#';
    }
}
