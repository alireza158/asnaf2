@if ($frontendVariant === 'compact')
<header id="header" class="site-header">
  <div class="site-container header-inner">
    <div class="header-hamburger" aria-label="منو" role="button" tabindex="0"><span class="hh-bar"></span></div>
    <a href="{{ route('home') }}" class="header-logo" aria-label="اتاق اصناف شهرستان گرگان">
      <img src="{{ asset('assets/img/asnaf-logo.svg') }}" alt="لوگوی اتاق اصناف شهرستان گرگان"/>
    </a>
    <div class="header-actions">
      <button class="search-trigger" aria-label="جستجو" aria-expanded="false"></button>
      <a href="{{ route('home') }}#friendship" class="header-cta-link">تماس با ما</a>
    </div>
    @include('frontend.partials.search')
  </div>
  <nav id="mainNav" class="top-nav">
    <div class="site-container top-nav-inner">
      <ul class="top-nav-list">
        @include('frontend.partials.dynamic-menu', ['location' => 'main', 'variant' => 'compact'])
      </ul>
    </div>
  </nav>
</header>
@else
@php($activeMenu = trim($__env->yieldContent('active_menu', '')))
<header class="site-header">
<div class="header-top site-container">
<div class="brand-note">
<img alt="پرچم ایران" class="flag-img" src="{{ asset('assets/img/flag-iran.png') }}"/>
<div>
<span>دوشنبه، ۱۴ اردیبهشت ۱۴۰۵</span>
<strong>اتاق اصناف شهرستان گرگان؛ پشتیبان کسب‌وکارهای صنفی</strong>
</div>
</div>
<div class="header-left-actions" aria-label="راه‌های دسترسی سریع هدر">
<a class="header-service-pill" href="{{ route('home') }}#commissions">سامانه خدمات صنفی</a>
<a class="header-contact-card" href="tel:01732152912">
<span>تماس با اتاق</span>
<strong>۰۱۷۳۲۱۵۲۹۱۲</strong>
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
@include('frontend.partials.dynamic-menu', ['location' => 'main', 'variant' => 'classic', 'activeMenu' => $activeMenu])
</ul>
</div>
<button aria-controls="headerSearchPanel" aria-expanded="false" aria-label="جستجو در سایت" class="search-trigger" type="button">
<span class="visually-hidden">جستجو</span>
</button>
</nav>
@include('frontend.partials.search')
</header>
@endif
