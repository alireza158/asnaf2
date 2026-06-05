@php
    $settings = app(\App\Services\SettingService::class);
    $siteTitle = $settings->get('site.site_title', 'اتاق اصناف شهرستان گرگان');
    $headerLogo = $settings->get('header.header_logo') ?: $settings->get('site.site_logo');
    $logoUrl = $headerLogo ? Storage::url($headerLogo) : asset('assets/img/asnaf-logo.svg');
    $topText = $settings->get('header.top_text', 'اتاق اصناف شهرستان گرگان؛ پشتیبان کسب‌وکارهای صنفی');
    $topDateEnabled = $settings->get('header.top_date_enabled', true);
    $contactText = $settings->get('header.contact_button_text', 'تماس با اتاق');
    $contactLink = $settings->get('header.contact_button_link', route('contact.create'));
    $serviceText = $settings->get('header.service_button_text', 'سامانه خدمات صنفی');
    $serviceLink = $settings->get('header.service_button_link', route('systems.index'));
    $specialLinks = collect([1, 2])->map(fn ($i) => [
        'title' => $settings->get("header.special_link_{$i}_title"),
        'url' => $settings->get("header.special_link_{$i}_url"),
        'icon' => $settings->get("header.special_link_{$i}_icon"),
        'color' => $settings->get("header.special_link_{$i}_color"),
        'active' => $settings->get("header.special_link_{$i}_active", false),
    ])->filter(fn ($link) => $link['active'] && $link['title'] && $link['url']);
@endphp
@if ($frontendVariant === 'compact')
<header id="header" class="site-header">
  <div class="site-container header-inner">
    <div class="header-hamburger" aria-label="منو" role="button" tabindex="0"><span class="hh-bar"></span></div>
    <a href="{{ route('home') }}" class="header-logo" aria-label="{{ $siteTitle }}"><img src="{{ $logoUrl }}" alt="{{ $siteTitle }}"/></a>
    <div class="header-actions">
      <button class="search-trigger" aria-label="جستجو" aria-expanded="false"></button>
      <a href="{{ $contactLink }}" class="header-cta-link">{{ $contactText }}</a>
    </div>
    @include('frontend.partials.search')
  </div>
  <nav id="mainNav" class="top-nav"><div class="site-container top-nav-inner"><ul class="top-nav-list">@include('frontend.partials.dynamic-menu', ['location' => 'main', 'variant' => 'compact'])</ul></div></nav>
</header>
@else
@php($activeMenu = trim($__env->yieldContent('active_menu', '')))
<header class="site-header">
<div class="header-top site-container"><div class="brand-note"><img alt="پرچم ایران" class="flag-img" src="{{ asset('assets/img/flag-iran.png') }}"/><div>@if($topDateEnabled)<span>{{ jalali_date(now()) }}</span>@endif<strong>{{ $topText }}</strong></div></div><div class="header-left-actions" aria-label="راه‌های دسترسی سریع هدر">
<a class="header-service-pill" href="{{ $serviceLink }}">{{ $serviceText }}</a>
@foreach($specialLinks as $link)<a class="header-service-pill" href="{{ $link['url'] }}" style="{{ $link['color'] ? 'background:'.$link['color'].';color:#fff' : '' }}">{{ $link['icon'] }} {{ $link['title'] }}</a>@endforeach
<a class="header-contact-card" href="{{ $contactLink }}"><span>{{ $contactText }}</span><strong>{{ $settings->get('site.phone', '۰۱۷۳۲۱۵۲۹۱۲') }}</strong></a>
</div></div>
<div aria-hidden="true" class="black-rail site-container"></div>
<nav aria-label="منوی اصلی" class="navbar navbar-expand-lg main-navbar site-container"><a href="{{ route('home') }}" class="header-logo" aria-label="{{ $siteTitle }}"><img src="{{ $logoUrl }}" alt="{{ $siteTitle }}"/></a><button aria-controls="mainNav" aria-expanded="false" aria-label="باز کردن منو" class="navbar-toggler" data-bs-target="#mainNav" data-bs-toggle="collapse" type="button"><span class="navbar-toggler-icon"></span></button><div class="collapse navbar-collapse" id="mainNav"><ul class="navbar-nav me-auto mb-2 mb-lg-0 nav-dots top-nav-menu">@include('frontend.partials.dynamic-menu', ['location' => 'main', 'variant' => 'classic', 'activeMenu' => $activeMenu])</ul></div><button aria-controls="headerSearchPanel" aria-expanded="false" aria-label="جستجو در سایت" class="search-trigger" type="button"><span class="visually-hidden">جستجو</span></button></nav>
@include('frontend.partials.search')
</header>
@endif
