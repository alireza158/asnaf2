@php
    $adminMenuItems = [
        ['title' => 'داشبورد', 'icon' => '🏠', 'active' => true],
        ['title' => 'کاربران', 'icon' => '👤'],
        ['title' => 'نقش‌ها و دسترسی‌ها', 'icon' => '🔐'],
        ['title' => 'منوها', 'icon' => '☰'],
        ['title' => 'صفحات', 'icon' => '📄'],
        ['title' => 'اخبار', 'icon' => '📰'],
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
            <a class="admin-nav-link {{ ! empty($item['active']) ? 'is-active' : '' }}" href="{{ ! empty($item['active']) ? route('admin.dashboard') : '#' }}">
                <span class="admin-nav-icon">{{ $item['icon'] }}</span>
                <span>{{ $item['title'] }}</span>
            </a>
        @endforeach
    </nav>
</aside>
