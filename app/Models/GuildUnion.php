<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GuildUnion extends Model
{
    use HasFactory;

    public const TYPE_PRODUCTION = 'production';
    public const TYPE_DISTRIBUTION = 'distribution';
    public const TYPE_SERVICE = 'service';
    public const TYPE_SPECIALIZED = 'specialized';

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
        'category_id',
        'manager_image',
        'working_hours',
        'social_links',
        'settings',
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
            'settings' => 'array',
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


    public static function sectionDefaults(): array
    {
        return [
            'show_manager' => true,
            'show_board_members' => true,
            'show_commissions' => true,
            'show_commission_tasks' => true,
            'show_rules' => true,
            'show_news_slider' => true,
            'show_news' => true,
            'show_articles' => true,
            'show_prices' => false,
            'show_complaint' => true,
            'show_minutes' => true,
            'show_education' => true,
            'show_announcements' => true,
            'show_gallery' => true,
            'show_videos' => true,
            'show_search' => true,
            'show_contact' => true,
            'show_social_links' => true,
        ];
    }

    public static function sectionLabels(): array
    {
        return [
            'show_manager' => 'نمایش رئیس اتحادیه',
            'show_board_members' => 'نمایش اعضای هیئت مدیره',
            'show_commissions' => 'نمایش کمیسیون‌ها',
            'show_commission_tasks' => 'نمایش وظایف کمیسیون‌ها',
            'show_rules' => 'نمایش قوانین و دستورالعمل‌ها',
            'show_news_slider' => 'نمایش اسلایدر خبری',
            'show_news' => 'نمایش آخرین اخبار',
            'show_articles' => 'نمایش مقاله‌ها',
            'show_prices' => 'نمایش نرخ‌نامه',
            'show_complaint' => 'نمایش ثبت شکایت',
            'show_minutes' => 'نمایش صورتجلسه‌ها',
            'show_education' => 'نمایش آموزش‌ها',
            'show_announcements' => 'نمایش اطلاعیه‌ها و بخشنامه‌ها',
            'show_gallery' => 'نمایش گالری تصاویر',
            'show_videos' => 'نمایش ویدیوها',
            'show_search' => 'نمایش جستجو',
            'show_contact' => 'نمایش اطلاعات تماس',
            'show_social_links' => 'نمایش شبکه‌های اجتماعی',
        ];
    }

    public function isSectionEnabled(string $key, bool $default = true): bool
    {
        $settings = $this->settings ?? [];

        return array_key_exists($key, $settings) ? (bool) $settings[$key] : $default;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
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

    public function commissions(): HasMany
    {
        return $this->hasMany(UnionCommission::class, 'union_id')->orderBy('sort_order')->orderBy('id');
    }


    public function rules(): HasMany
    {
        return $this->hasMany(UnionRule::class, 'union_id')->orderBy('sort_order')->orderBy('id');
    }

    public function minutes(): HasMany
    {
        return $this->hasMany(UnionMinute::class, 'union_id')->orderByDesc('meeting_date')->orderBy('sort_order');
    }

    public function educations(): HasMany
    {
        return $this->hasMany(UnionEducation::class, 'union_id')->orderBy('sort_order')->orderBy('id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(UnionPrice::class, 'union_id')->orderBy('sort_order')->orderBy('id');
    }

    public function activeCommissions(): HasMany
    {
        return $this->commissions()->active();
    }

    public function getSocialLinkItemsAttribute(): array
    {
        return collect($this->social_links ?? [])
            ->filter(fn ($url) => filled($url))
            ->map(fn ($url, $label) => ['label' => (string) $label, 'url' => (string) $url])
            ->values()
            ->all();
    }

    public static function typeLabels(): array
    {
        return [
            self::TYPE_PRODUCTION => 'اتحادیه‌های تولیدی',
            self::TYPE_DISTRIBUTION => 'اتحادیه‌های توزیعی',
            self::TYPE_SERVICE => 'اتحادیه‌های خدماتی',
            self::TYPE_SPECIALIZED => 'اتحادیه‌های تخصصی',
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
