<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commission extends Model
{
    use HasFactory;

    public const STATUSES = ['draft', 'published', 'archived'];

    protected $fillable = ['title', 'slug', 'description', 'image', 'members', 'attachments', 'status', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return ['members' => 'array', 'attachments' => 'array', 'sort_order' => 'integer', 'is_active' => 'boolean'];
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(CommissionSession::class)->orderByDesc('session_date')->orderBy('sort_order');
    }

    public function publishedSessions(): HasMany
    {
        return $this->sessions()->published();
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->where('is_active', true);
    }

    public static function statusLabels(): array
    {
        return ['draft' => 'پیش‌نویس', 'published' => 'منتشر شده', 'archived' => 'آرشیو شده'];
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statusLabels()[$this->status] ?? $this->status;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
