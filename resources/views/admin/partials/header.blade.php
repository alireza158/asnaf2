<header class="admin-header">
    <div class="admin-header-start">
        <button class="admin-menu-toggle" type="button" aria-label="باز کردن منوی مدیریت" data-admin-sidebar-toggle>
            <span></span>
            <span></span>
            <span></span>
        </button>
        <div>
            <p class="admin-eyebrow">سامانه مدیریت محتوا</p>
            <h1>@yield('title', 'داشبورد مدیریت')</h1>
        </div>
    </div>

    <div class="admin-header-end">
        <div class="admin-search" role="search">
            <span>🔎</span>
            <input type="search" placeholder="جستجو در پنل..." aria-label="جستجو در پنل مدیریت">
        </div>
        <a class="admin-view-site" href="{{ route('home') }}" target="_blank" rel="noopener">مشاهده سایت</a>
        <div class="admin-user-card">
            <div class="admin-avatar">م</div>
            <div>
                <strong>مدیر سامانه</strong>
                <span>خوش آمدید</span>
            </div>
        </div>
    </div>
</header>
