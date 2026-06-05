<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GuildUnion extends Model
{
    use HasFactory;

    public const TYPE_PRODUCTION = 'production';
    public const TYPE_DISTRIBUTION = 'distribution';
    public const TYPE_SERVICE = 'service';

    protected $table = 'unions';

    protected $fillable = [
        'name',
        'title',
        'slug',
        'logo',
        'cover_image',
        'description',
        'short_description',
        'address',
        'phone',
        'mobile',
        'email',
        'website',
        'manager_name',
        'union_type',
        'manager_image',
        'working_hours',
        'social_links',
        'complaint_enabled',
        'congratulations_enabled',
        'news_enabled',
        'announcements_enabled',
        'gallery_enabled',
        'videos_enabled',
        'members_enabled',
        'services_enabled',
        'is_active',
        'sort_order',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected function casts(): array
    {
        return [
            'social_links' => 'array',
            'complaint_enabled' => 'boolean',
            'congratulations_enabled' => 'boolean',
            'news_enabled' => 'boolean',
            'announcements_enabled' => 'boolean',
            'gallery_enabled' => 'boolean',
            'videos_enabled' => 'boolean',
            'members_enabled' => 'boolean',
            'services_enabled' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'union_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(UnionMember::class, 'union_id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'union_id');
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class, 'union_id');
    }

    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class, 'union_id');
    }

    public function smsLogs(): HasMany
    {
        return $this->hasMany(SmsLog::class, 'union_id');
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class, 'union_id');
    }

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class, 'union_id');
    }

    public function congratulationMessages(): HasMany
    {
        return $this->hasMany(CongratulationMessage::class, 'union_id');
    }

    public static function typeLabels(): array
    {
        return [
            self::TYPE_PRODUCTION => 'اتحادیه‌های تولیدی',
            self::TYPE_DISTRIBUTION => 'اتحادیه‌های توزیعی',
            self::TYPE_SERVICE => 'اتحادیه‌های خدماتی',
        ];
    }

    public function getUnionTypeLabelAttribute(): string
    {
        return self::typeLabels()[$this->union_type] ?? 'نامشخص';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getDisplayTitleAttribute(): string
    {
        return $this->title ?: $this->name;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
