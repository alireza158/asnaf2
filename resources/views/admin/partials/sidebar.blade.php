@php
    $adminMenuItems = [
        ['title' => 'داشبورد', 'icon' => '🏠', 'route' => 'admin.dashboard'],
        ['title' => 'کاربران', 'icon' => '👤', 'route' => 'admin.users.index'],
        ['title' => 'نقش‌ها و دسترسی‌ها', 'icon' => '🔐', 'route' => 'admin.roles.index'],
        ['title' => 'منوها', 'icon' => '☰', 'route' => 'admin.menus.index'],
        ['title' => 'صفحات', 'icon' => '📄', 'route' => 'admin.pages.index'],
        ['title' => 'اخبار', 'icon' => '📰', 'route' => 'admin.posts.index'],
        ['title' => 'اطلاعیه‌ها', 'icon' => '📣'],
        ['title' => 'اتحادیه‌ها', 'icon' => '🏢'],
        ['title' => 'اعضای اتحادیه‌ها', 'icon' => '🤝'],
        ['title' => 'شکایات', 'icon' => '📨'],
        ['title' => 'گالری تصاویر', 'icon' => '🖼️'],
        ['title' => 'ویدیوها', 'icon' => '▶️'],
        ['title' => 'گردشگری', 'icon' => '🌿'],
        ['title' => 'تبلیغات', 'icon' => '📌'],
        ['title' => 'سامانه‌ها', 'icon' => '💻'],
        ['title' => 'کمیسیون‌ها', 'icon' => '⚖️'],
        ['title' => 'تنظیمات صفحه اصلی', 'icon' => '🧩'],
        ['title' => 'تنظیمات هدر', 'icon' => '🔝'],
        ['title' => 'تنظیمات فوتر', 'icon' => '🔚'],
        ['title' => 'پیامک‌ها', 'icon' => '💬'],
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
