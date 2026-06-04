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
        <li class="top-nav-item"><a href="{{ route('home') }}" class="top-nav-link">خانه</a></li>
        <li class="top-nav-item has-top-submenu">
          <button class="top-nav-link" aria-expanded="false">اصناف و اتحادیه‌ها</button>
          <div class="top-submenu">
            <a href="{{ route('guilds.show', 'gold-union') }}">معرفی اتحادیه طلا</a>
            <a href="{{ route('posts.index') }}">آرشیو اتحادیه‌ها</a>
          </div>
        </li>
        <li class="top-nav-item"><a href="{{ route('posts.index') }}" class="top-nav-link">اخبار و مقالات</a></li>
        <li class="top-nav-item"><a href="{{ route('galleries.index') }}" class="top-nav-link">گالری تصاویر</a></li>
        @if (trim($__env->yieldContent('compact_show_tourism_nav', 'true')) !== 'false')
        <li class="top-nav-item"><a href="{{ route('tourism.index') }}" class="top-nav-link">گردشگری</a></li>
        @endif
        <li class="top-nav-item"><a href="{{ route('pages.show', 'services') }}" class="top-nav-link">خدمات الکترونیک</a></li>
        <li class="top-nav-item"><a href="{{ route('home') }}#friendship" class="top-nav-link">تماس با ما</a></li>
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
<li class="nav-item"><a class="nav-link{{ $activeMenu === 'home' ? ' active' : '' }}" href="{{ $activeMenu === 'home' ? '#' : route('home') }}">صفحه اصلی</a></li>
<li class="nav-item top-nav-item has-top-submenu">
<button aria-expanded="false" class="nav-link top-nav-link" type="button">درباره اتاق<span class="top-submenu-caret"></span></button>
<ul class="top-submenu"><li><a href="{{ route('home') }}#representatives">معرفی اتاق اصناف گرگان</a></li><li><a href="{{ route('home') }}#representatives">هیئت رئیسه و ساختار اداری</a></li><li><a href="{{ route('home') }}#friendship">آدرس و راهنمای مراجعه</a></li></ul>
</li>
<li class="nav-item top-nav-item has-top-submenu">
<button aria-expanded="false" class="nav-link top-nav-link" type="button">خدمات صنفی<span class="top-submenu-caret"></span></button>
<ul class="top-submenu"><li><a href="{{ route('home') }}#fractions">صدور پروانه کسب</a></li><li><a href="{{ route('home') }}#fractions">تمدید و انتقال پروانه</a></li><li><a href="{{ route('home') }}#commissions">فرم‌ها و درخواست‌ها</a></li></ul>
</li>
<li class="nav-item top-nav-item has-top-submenu">
<button aria-expanded="false" class="nav-link top-nav-link" type="button">اتحادیه‌ها<span class="top-submenu-caret"></span></button>
<ul class="top-submenu"><li><a href="{{ route('home') }}#commissions">فهرست اتحادیه‌های صنفی</a></li><li><a href="{{ route('guilds.show', 'gold-union') }}">رسته‌های شغلی</a></li><li><a href="{{ route('home') }}#friendship">اطلاعات تماس اتحادیه‌ها</a></li></ul>
</li>
<li class="nav-item top-nav-item has-top-submenu">
<button aria-expanded="false" class="nav-link top-nav-link" type="button">بازرسی و نظارت<span class="top-submenu-caret"></span></button>
<ul class="top-submenu"><li><a href="{{ route('home') }}#friendship">ثبت شکایت صنفی</a></li><li><a href="{{ route('home') }}#friendship">گزارش تخلف</a></li><li><a href="{{ route('home') }}#friendship">پیگیری بازرسی‌ها</a></li></ul>
</li>
<li class="nav-item top-nav-item has-top-submenu">
<button aria-expanded="false" class="nav-link top-nav-link" type="button">آموزش و اطلاعیه‌ها<span class="top-submenu-caret"></span></button>
<ul class="top-submenu"><li><a href="{{ route('home') }}#fractions">دوره‌های آموزشی</a></li><li><a href="{{ route('home') }}#multimedia">بخشنامه‌ها و اطلاعیه‌ها</a></li><li><a href="{{ route('posts.index') }}">اخبار اتاق اصناف</a></li></ul>
</li>
<li class="nav-item top-nav-item has-top-submenu">
<button aria-expanded="false" class="nav-link top-nav-link" type="button">سامانه‌ها<span class="top-submenu-caret"></span></button>
<ul class="top-submenu"><li><a href="{{ route('home') }}#commissions">سامانه نوین اصناف</a></li><li><a href="{{ route('home') }}#fractions">سامانه آموزش اصناف</a></li><li><a href="{{ route('home') }}#multimedia">راهنمای خدمات الکترونیک</a></li></ul>
</li>
<li class="nav-item"><a class="nav-link" href="{{ route('galleries.index') }}">گالری تصاویر</a></li>
<li class="nav-item"><a class="nav-link" href="{{ route('tourism.index') }}">گردشگری</a></li>
<li class="nav-item"><a class="nav-link" href="{{ route('home') }}#friendship">تماس با ما</a></li>
</ul>
</div>
<button aria-controls="headerSearchPanel" aria-expanded="false" aria-label="جستجو در سایت" class="search-trigger" type="button">
<span class="visually-hidden">جستجو</span>
</button>
</nav>
@include('frontend.partials.search')
</header>
@endif
