<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    public const TYPES = ['news', 'article', 'announcement'];
    public const STATUSES = ['draft', 'pending', 'approved', 'rejected', 'published', 'archived'];
    public const LIMITED_STATUSES = ['draft', 'pending'];

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'featured_image',
        'category_id',
        'union_id',
        'type',
        'is_important',
        'is_featured',
        'views_count',
        'status',
        'published_at',
        'created_by',
        'approved_by',
        'rejected_reason',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_important' => 'boolean',
            'is_featured' => 'boolean',
            'views_count' => 'integer',
            'published_at' => 'datetime',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    public function union(): BelongsTo
    {
        return $this->belongsTo(GuildUnion::class, 'union_id');
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(PostGallery::class)->orderBy('sort_order')->orderBy('id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->where('is_active', true);
    }

    public function scopeImportant($query)
    {
        return $query->where('is_important', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
