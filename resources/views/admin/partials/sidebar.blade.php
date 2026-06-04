@php
    $adminMenuItems = [
        ['title' => 'داشبورد', 'icon' => '🏠', 'route' => 'admin.dashboard'],
        ['title' => 'کاربران', 'icon' => '👤', 'route' => 'admin.users.index'],
        ['title' => 'نقش‌ها و دسترسی‌ها', 'icon' => '🔐', 'route' => 'admin.roles.index'],
        ['title' => 'منوها', 'icon' => '☰', 'route' => 'admin.menus.index'],
        ['title' => 'صفحات', 'icon' => '📄', 'route' => 'admin.pages.index'],
        ['title' => 'اخبار', 'icon' => '📰', 'route' => 'admin.posts.index'],
        ['title' => 'اطلاعیه‌ها', 'icon' => '📣', 'route' => 'admin.announcements.index'],
        ['title' => 'اتحادیه‌ها', 'icon' => '🏢', 'route' => 'admin.unions.index'],
        ['title' => 'اعضای اتحادیه‌ها', 'icon' => '🤝', 'route' => 'admin.union_members.index'],
        ['title' => 'شکایات', 'icon' => '📨', 'route' => 'admin.complaints.index'],
        ['title' => 'گالری تصاویر', 'icon' => '🖼️', 'route' => 'admin.galleries.index'],
        ['title' => 'ویدیوها', 'icon' => '▶️', 'route' => 'admin.videos.index'],
        ['title' => 'گردشگری', 'icon' => '🌿', 'route' => 'admin.tourism.index'],
        ['title' => 'تبلیغات', 'icon' => '📌', 'route' => 'admin.advertisements.index'],
        ['title' => 'سامانه‌ها', 'icon' => '💻', 'route' => 'admin.systems.index'],
        ['title' => 'کمیسیون‌ها', 'icon' => '⚖️'],
        ['title' => 'تنظیمات صفحه اصلی', 'icon' => '🧩', 'route' => 'admin.home_sections.index'],
        ['title' => 'تنظیمات هدر', 'icon' => '🔝'],
        ['title' => 'تنظیمات فوتر', 'icon' => '🔚'],
        ['title' => 'پیامک‌ها', 'icon' => '💬', 'route' => 'admin.sms.index'],
        ['title' => 'پیام‌های تماس', 'icon' => '☎️'],
        ['title' => 'تنظیمات سایت', 'icon' => '⚙️'],
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
        @foreach ($adminMenuItems as $item)
            @php($routeName = $item['route'] ?? null)
            <a class="admin-nav-link {{ $routeName && request()->routeIs($routeName) ? 'is-active' : '' }}" href="{{ $routeName ? route($routeName) : '#' }}">
                <span class="admin-nav-icon">{{ $item['icon'] }}</span>
                <span>{{ $item['title'] }}</span>
            </a>
        @endforeach
    </nav>
</aside>
