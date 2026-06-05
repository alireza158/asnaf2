@php
    $adminMenuGroups = [
        [
            'title' => 'اصلی',
            'items' => [
                ['title' => 'داشبورد', 'icon' => '🏠', 'route' => 'admin.dashboard', 'match' => 'admin.dashboard'],
            ],
        ],
        [
            'title' => 'مدیریت محتوا',
            'items' => [
                ['title' => 'صفحات', 'icon' => '📄', 'route' => 'admin.pages.index', 'match' => 'admin.pages.*'],
                ['title' => 'اخبار', 'icon' => '📰', 'route' => 'admin.posts.index', 'match' => 'admin.posts.*'],
                ['title' => 'اطلاعیه‌ها', 'icon' => '📣', 'route' => 'admin.announcements.index', 'match' => 'admin.announcements.*'],
                ['title' => 'پیام‌های تبریک', 'icon' => '🎉', 'route' => 'admin.congratulation_messages.index', 'match' => 'admin.congratulation_messages.*'],
                ['title' => 'گردشگری', 'icon' => '🌿', 'route' => 'admin.tourism.index', 'match' => 'admin.tourism.*'],
                ['title' => 'کمیسیون‌ها', 'icon' => '⚖️', 'route' => 'admin.commissions.index', 'match' => 'admin.commissions.*'],
                ['title' => 'در انتظار تایید', 'icon' => '✅', 'route' => 'admin.pending_approvals.index', 'match' => 'admin.pending_approvals.*'],
            ],
        ],
        [
            'title' => 'مدیریت اتحادیه‌ها',
            'items' => [
                ['title' => 'اتحادیه‌ها', 'icon' => '🏢', 'route' => 'admin.unions.index', 'match' => 'admin.unions.*'],
                ['title' => 'اعضای اتحادیه‌ها', 'icon' => '🤝', 'route' => 'admin.union_members.index', 'match' => 'admin.union_members.*'],
                ['title' => 'شکایات', 'icon' => '📨', 'route' => 'admin.complaints.index', 'match' => 'admin.complaints.*'],
            ],
        ],
        [
            'title' => 'رسانه‌ها',
            'items' => [
                ['title' => 'گالری تصاویر', 'icon' => '🖼️', 'route' => 'admin.galleries.index', 'match' => 'admin.galleries.*'],
                ['title' => 'ویدیوها', 'icon' => '▶️', 'route' => 'admin.videos.index', 'match' => 'admin.videos.*'],
                ['title' => 'تبلیغات', 'icon' => '📌', 'route' => 'admin.advertisements.index', 'match' => ['admin.advertisements.*', 'admin.advertisement_positions.*']],
            ],
        ],
        [
            'title' => 'ارتباطات',
            'items' => [
                ['title' => 'پیامک‌ها', 'icon' => '💬', 'route' => 'admin.sms.index', 'match' => 'admin.sms.*'],
                ['title' => 'پیام‌های تماس', 'icon' => '☎️', 'route' => 'admin.contact_messages.index', 'match' => 'admin.contact_messages.*'],
            ],
        ],
        [
            'title' => 'تنظیمات',
            'items' => [
                ['title' => 'منوها', 'icon' => '☰', 'route' => 'admin.menus.index', 'match' => 'admin.menus.*'],
                ['title' => 'سامانه‌ها', 'icon' => '💻', 'route' => 'admin.systems.index', 'match' => 'admin.systems.*'],
                ['title' => 'خدمات الکترونیک', 'icon' => '⚡', 'route' => 'admin.electronic_services.index', 'match' => 'admin.electronic_services.*'],
                ['title' => 'تنظیمات صفحه اصلی', 'icon' => '🧩', 'route' => 'admin.home_sections.index', 'match' => 'admin.home_sections.*'],
                ['title' => 'تنظیمات هدر', 'icon' => '🔝', 'route' => 'admin.header_settings.edit', 'match' => 'admin.header_settings.*'],
                ['title' => 'تنظیمات فوتر', 'icon' => '🔚', 'route' => 'admin.footer_settings.edit', 'match' => 'admin.footer_settings.*'],
                ['title' => 'تنظیمات سایت', 'icon' => '⚙️', 'route' => 'admin.settings.edit', 'match' => 'admin.settings.*'],
            ],
        ],
        [
            'title' => 'کاربران و دسترسی',
            'items' => [
                ['title' => 'کاربران', 'icon' => '👤', 'route' => 'admin.users.index', 'match' => 'admin.users.*'],
                ['title' => 'نقش‌ها و دسترسی‌ها', 'icon' => '🔐', 'route' => 'admin.roles.index', 'match' => ['admin.roles.*', 'admin.permissions.*']],
            ],
        ],
    ];
@endphp

<aside class="admin-sidebar" id="adminSidebar" aria-label="منوی مدیریت">
    <div class="admin-brand">
        <div class="admin-brand-mark">ا</div>
        <div>
            <strong>پنل مدیریت</strong>
            <span>اتاق اصناف گرگان</span>
        </div>
    </div>

    <nav class="admin-sidebar-nav">
        @foreach ($adminMenuGroups as $group)
            <section class="admin-nav-group" aria-label="{{ $group['title'] }}">
                <h2 class="admin-nav-group-title">{{ $group['title'] }}</h2>
                @foreach ($group['items'] as $item)
                    @php
                        $matchPatterns = (array) ($item['match'] ?? $item['route']);
                        $isActive = collect($matchPatterns)->contains(fn ($pattern) => request()->routeIs($pattern));
                    @endphp
                    <a class="admin-nav-link {{ $isActive ? 'is-active' : '' }}" href="{{ route($item['route']) }}" @if($isActive) aria-current="page" @endif>
                        <span class="admin-nav-icon">{{ $item['icon'] }}</span>
                        <span>{{ $item['title'] }}</span>
                    </a>
                @endforeach
            </section>
        @endforeach
    </nav>
</aside>
