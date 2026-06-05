@php
    $settings = app(\App\Services\SettingService::class);
    $topItems = app(\App\Services\MenuService::class)->items('top');
    $mainItems = app(\App\Services\MenuService::class)->items('main');
    $topText = $settings->get('header.top_text', 'اتاق اصناف شهرستان گرگان؛ پشتیبان کسب‌وکارهای صنفی');
    $serviceText = $settings->get('header.service_button_text', 'سامانه خدمات صنفی');
    $serviceLink = $settings->get('header.service_button_link', '#commissions');
    $phone = $settings->get('site.phone', '۰۱۷۳۲۱۵۲۹۱۲');
    $contactText = $settings->get('header.contact_button_text', 'تماس با اتاق');
    $jalaliParts = explode('/', jalali_date(now(), 'Y/m/d'));
    $weekdays = ['یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنجشنبه', 'جمعه', 'شنبه'];
    $months = [1 => 'فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'];
    $todayLabel = ($weekdays[now()->dayOfWeek] ?? '') . '، ' . (int) ($jalaliParts[2] ?? 1) . ' ' . ($months[(int) ($jalaliParts[1] ?? 1)] ?? '') . ' ' . ($jalaliParts[0] ?? '');
@endphp
<header class="site-header">
<div class="header-top site-container">
<div class="brand-note">
<img alt="پرچم ایران" class="flag-img" src="{{ asset('assets/img/flag-iran.png') }}"/>
<div>
<span>{{ $todayLabel }}</span>
<strong>{{ $topText }}</strong>
</div>
</div>

<div class="header-left-actions" aria-label="راه‌های دسترسی سریع هدر">
@if($topItems->isNotEmpty())
@php($topItem = $topItems->first())
<a class="header-service-pill" href="{{ $topItem->resolved_url ?: $serviceLink }}" target="{{ $topItem->target }}">{{ $topItem->title }}</a>
@else
<a class="header-service-pill" href="{{ $serviceLink }}">{{ $serviceText }}</a>
@endif
<a class="header-contact-card" href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}">
<span>{{ $contactText }}</span>
<strong>{{ $phone }}</strong>
</a>
</div>
</div>
<div aria-hidden="true" class="black-rail site-container"></div>
<nav aria-label="منوی اصلی" class="navbar navbar-expand-lg main-navbar site-container">
<button aria-controls="mainNav" aria-expanded="false" aria-label="باز کردن منو" class="navbar-toggler" data-bs-target="#mainNav" data-bs-toggle="collapse" type="button">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="mainNav">
<ul class="navbar-nav me-auto mb-2 mb-lg-0 nav-dots top-nav-menu">
@if($mainItems->isNotEmpty())
    @foreach($mainItems as $menuItem)
        @include('frontend.partials.dynamic-menu-item', ['menuItem' => $menuItem, 'variant' => 'classic', 'itemClass' => 'nav-item', 'linkClass' => 'nav-link'])
    @endforeach
@else
<li class="nav-item"><a class="nav-link active" href="{{ route('home') }}">صفحه اصلی</a></li>
<li class="nav-item top-nav-item has-top-submenu">
<button aria-expanded="false" class="nav-link top-nav-link" type="button">درباره اتاق<span class="top-submenu-caret"></span></button>
<ul class="top-submenu"><li><a href="#representatives">معرفی اتاق اصناف گرگان</a></li><li><a href="#representatives">هیئت رئیسه و ساختار اداری</a></li><li><a href="#friendship">آدرس و راهنمای مراجعه</a></li></ul>
</li>
<li class="nav-item top-nav-item has-top-submenu">
<button aria-expanded="false" class="nav-link top-nav-link" type="button">خدمات صنفی<span class="top-submenu-caret"></span></button>
<ul class="top-submenu"><li><a href="#fractions">صدور پروانه کسب</a></li><li><a href="#fractions">تمدید و انتقال پروانه</a></li><li><a href="#commissions">فرم‌ها و درخواست‌ها</a></li></ul>
</li>
<li class="nav-item top-nav-item has-top-submenu">
<button aria-expanded="false" class="nav-link top-nav-link" type="button">اتحادیه‌ها<span class="top-submenu-caret"></span></button>
<ul class="top-submenu"><li><a href="{{ route('guilds.index') }}">فهرست اتحادیه‌های صنفی</a></li><li><a href="#representatives">رسته‌های شغلی</a></li><li><a href="#friendship">اطلاعات تماس اتحادیه‌ها</a></li></ul>
</li>
<li class="nav-item top-nav-item has-top-submenu">
<button aria-expanded="false" class="nav-link top-nav-link" type="button">بازرسی و نظارت<span class="top-submenu-caret"></span></button>
<ul class="top-submenu"><li><a href="{{ route('complaints.create') }}">ثبت شکایت صنفی</a></li><li><a href="{{ route('complaints.create') }}">گزارش تخلف</a></li><li><a href="{{ route('complaints.track') }}">پیگیری بازرسی‌ها</a></li></ul>
</li>
<li class="nav-item top-nav-item has-top-submenu">
<button aria-expanded="false" class="nav-link top-nav-link" type="button">آموزش و اطلاعیه‌ها<span class="top-submenu-caret"></span></button>
<ul class="top-submenu"><li><a href="#fractions">دوره‌های آموزشی</a></li><li><a href="{{ route('announcements.index') }}">بخشنامه‌ها و اطلاعیه‌ها</a></li><li><a href="{{ route('posts.index') }}">اخبار اتاق اصناف</a></li></ul>
</li>
<li class="nav-item top-nav-item has-top-submenu">
<button aria-expanded="false" class="nav-link top-nav-link" type="button">سامانه‌ها<span class="top-submenu-caret"></span></button>
<ul class="top-submenu"><li><a href="{{ route('systems.index') }}">سامانه نوین اصناف</a></li><li><a href="#fractions">سامانه آموزش اصناف</a></li><li><a href="{{ route('electronic-services.index') }}">راهنمای خدمات الکترونیک</a></li></ul>
</li>
<li class="nav-item"><a class="nav-link" href="{{ route('galleries.index') }}">گالری تصاویر</a></li>
<li class="nav-item"><a class="nav-link" href="{{ route('tourism.index') }}">گردشگری</a></li>
<li class="nav-item"><a class="nav-link" href="#friendship">تماس با ما</a></li>
@endif
</ul>
</div>
<button aria-controls="headerSearchPanel" aria-expanded="false" aria-label="جستجو در سایت" class="search-trigger" type="button">
<span class="visually-hidden">جستجو</span>
</button>
</nav>
<div class="header-search-panel site-container" hidden="" id="headerSearchPanel">
<form autocomplete="off" action="{{ route('search') }}" method="GET" class="header-search-form" role="search">
<label class="header-search-label" for="siteSearchInput">جستجو در سایت</label>
<div class="header-search-field">
<input id="siteSearchInput" name="q" value="{{ request('q') }}" placeholder="عبارت مورد نظر را وارد کنید؛ مثل اتحادیه، پروانه کسب، شکایت، آموزش..." type="search"/>
<button type="submit">جستجو</button>
</div>
<div aria-live="polite" class="header-search-results"></div>
</form>
</div>
</header>
