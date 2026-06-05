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
        if ($this->type === 'custom') {
            return $this->url ?: '#';
        }

        $routeMap = [
            'page' => ['pages.show', \App\Models\Page::class],
            'post' => ['posts.show', \App\Models\Post::class],
            'union' => ['guilds.show', \App\Models\GuildUnion::class],
            'tourism' => ['tourism.show', \App\Models\TourismPlace::class],
            'gallery' => ['galleries.show', \App\Models\Gallery::class],
            'video' => ['videos.show', \App\Models\Video::class],
            'system' => ['systems.show', \App\Models\System::class],
            'service' => ['electronic_services.show', \App\Models\ElectronicService::class],
        ];

        if (isset($routeMap[$this->type]) && $this->reference_id) {
            [$routeName, $modelClass] = $routeMap[$this->type];
            try {
                $model = $modelClass::query()->find($this->reference_id);
                if ($model && Route::has($routeName)) {
                    return route($routeName, $model->getRouteKey());
                }
            } catch (Throwable) {
                return $this->url ?: '#';
            }
        }

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
