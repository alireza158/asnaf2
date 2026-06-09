<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    public const TYPES = ['news', 'article', 'announcement', 'video'];
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
        'is_top',
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
            'is_top' => 'boolean',
            'views_count' => 'integer',
            'published_at' => 'datetime',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }


    public function getShortDescriptionAttribute(): ?string
    {
        return $this->excerpt;
    }

    public function getDescriptionAttribute(): ?string
    {
        return $this->body;
    }

    public function getSummaryAttribute(): string
    {
        return $this->excerpt ?: Str::limit(strip_tags((string) $this->body), 120);
    }

    public function getCategoryTitleAttribute(): string
    {
        return $this->category?->title ?: 'عمومی';
    }

    public function getFeaturedImageUrlAttribute(): string
    {
        $image = $this->featured_image;

        if (! $image) {
            return asset('assets/img/asnaf-gorgan-default.jpg');
        }

        if (Str::startsWith($image, ['http://', 'https://', '/'])) {
            return $image;
        }

        if (Str::startsWith($image, ['assets/'])) {
            return asset($image);
        }

        return Storage::url($image);
    }

    public function getHasGalleryBadgeAttribute(): bool
    {
        return $this->relationLoaded('galleries') ? $this->galleries->isNotEmpty() : $this->galleries()->exists();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public static function typeLabels(): array
    {
        return [
            'news' => 'خبر',
            'article' => 'مقاله',
            'announcement' => 'اطلاعیه',
            'video' => 'ویدیو',
        ];
    }

    public static function statusLabels(): array
    {
        return [
            'draft' => 'پیش‌نویس',
            'pending' => 'در انتظار تایید',
            'approved' => 'تایید شده',
            'rejected' => 'رد شده',
            'published' => 'منتشر شده',
            'archived' => 'آرشیو شده',
        ];
    }

    public function getTypeLabelAttribute(): string
    {
        return self::typeLabels()[$this->type] ?? $this->type;
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statusLabels()[$this->status] ?? $this->status;
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
        return $query
            ->where('status', 'published')
            ->where('is_active', true)
            ->where(fn ($query) => $query->whereNull('published_at')->orWhere('published_at', '<=', now()));
    }

    public function scopeImportant($query)
    {
        return $query->where('is_important', true);
    }

    public function scopeTop($query)
    {
        return $query->where('is_top', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
