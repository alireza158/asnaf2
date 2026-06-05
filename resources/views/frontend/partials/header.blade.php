@php
    $settings = app(\App\Services\SettingService::class);
    $topItems = app(\App\Services\MenuService::class)->items('top');
    $mainItems = app(\App\Services\MenuService::class)->items('main');
    $logo = $settings->get('header.logo', 'assets/img/asnaf-wordmark.svg');
    $topText = $settings->get('header.top_text', 'اتاق اصناف شهرستان گرگان؛ پشتیبان کسب‌وکارهای صنفی');
    $serviceText = $settings->get('header.service_button_text', 'سامانه خدمات صنفی');
    $serviceLink = $settings->get('header.service_button_link', route('systems.index'));
    $phone = $settings->get('site.phone', '۰۱۷۳۲۱۵۲۹۱۲');
    $contactText = $settings->get('header.contact_button_text', 'تماس با اتاق');
@endphp
<header class="site-header">
<div class="header-top site-container">
<div class="brand-note">
<img alt="اتاق اصناف شهرستان گرگان" class="flag-img" src="{{ asset($logo) }}"/>
<div>
<span>{{ jalali_date(now(), 'Y/m/d') }}</span>
<strong>{{ $topText }}</strong>
</div>
</div>

<div class="header-left-actions" aria-label="راه‌های دسترسی سریع هدر">
@if($topItems->isNotEmpty())
    @foreach($topItems->take(3) as $topItem)
        <a class="header-service-pill" href="{{ $topItem->resolved_url }}" target="{{ $topItem->target }}">{{ $topItem->title }}</a>
    @endforeach
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
<li class="nav-item"><a class="nav-link" href="{{ route('posts.index') }}">اخبار</a></li>
<li class="nav-item"><a class="nav-link" href="{{ route('guilds.index') }}">اتحادیه‌ها</a></li>
<li class="nav-item"><a class="nav-link" href="{{ route('contact.create') }}">تماس با ما</a></li>
@endif
</ul>
</div>
<button aria-controls="headerSearchPanel" aria-expanded="false" aria-label="جستجو در سایت" class="search-trigger" type="button">
<span class="visually-hidden">جستجو</span>
</button>
</nav>
<div class="header-search-panel site-container" hidden="" id="headerSearchPanel">
<form autocomplete="off" action="{{ route('search') }}" method="get" class="header-search-form" role="search">
<label class="header-search-label" for="siteSearchInput">جستجو در سایت</label>
<div class="header-search-field">
<input id="siteSearchInput" name="q" value="{{ request('q') }}" placeholder="عبارت مورد نظر را وارد کنید؛ مثل اتحادیه، پروانه کسب، شکایت، آموزش..." type="search"/>
<button type="submit">جستجو</button>
</div>
<div aria-live="polite" class="header-search-results"></div>
</form>
</div>
</header>
