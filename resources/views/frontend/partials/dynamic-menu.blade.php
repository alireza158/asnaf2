@php
    $location = $location ?? 'main';
    $variant = $variant ?? 'classic';
    $items = app(\App\Services\MenuService::class)->items($location);
    $linkClass = $variant === 'compact' ? 'top-nav-link' : 'nav-link';
    $itemClass = $variant === 'compact' ? 'top-nav-item' : 'nav-item';
@endphp

@if ($items->isNotEmpty())
    @foreach ($items as $menuItem)
        @include('frontend.partials.dynamic-menu-item', ['menuItem' => $menuItem, 'variant' => $variant, 'itemClass' => $itemClass, 'linkClass' => $linkClass])
    @endforeach
@else
    @if ($variant === 'compact')
        <li class="top-nav-item"><a href="{{ route('home') }}" class="top-nav-link">خانه</a></li>
        <li class="top-nav-item has-top-submenu">
            <button class="top-nav-link" aria-expanded="false">اصناف و اتحادیه‌ها</button>
            <div class="top-submenu"><a href="{{ route('guilds.show', 'gold-union') }}">معرفی اتحادیه طلا</a><a href="{{ route('posts.index') }}">آرشیو اتحادیه‌ها</a></div>
        </li>
        <li class="top-nav-item"><a href="{{ route('posts.index') }}" class="top-nav-link">اخبار و مقالات</a></li>
        <li class="top-nav-item"><a href="{{ route('galleries.index') }}" class="top-nav-link">گالری تصاویر</a></li>
        @if (trim($__env->yieldContent('compact_show_tourism_nav', 'true')) !== 'false')<li class="top-nav-item"><a href="{{ route('tourism.index') }}" class="top-nav-link">گردشگری</a></li>@endif
        <li class="top-nav-item"><a href="{{ route('pages.show', 'services') }}" class="top-nav-link">خدمات الکترونیک</a></li>
        <li class="top-nav-item"><a href="{{ route('home') }}#friendship" class="top-nav-link">تماس با ما</a></li>
    @else
        <li class="nav-item"><a class="nav-link{{ ($activeMenu ?? '') === 'home' ? ' active' : '' }}" href="{{ ($activeMenu ?? '') === 'home' ? '#' : route('home') }}">صفحه اصلی</a></li>
        <li class="nav-item top-nav-item has-top-submenu"><button aria-expanded="false" class="nav-link top-nav-link" type="button">درباره اتاق<span class="top-submenu-caret"></span></button><ul class="top-submenu"><li><a href="{{ route('home') }}#representatives">معرفی اتاق اصناف گرگان</a></li><li><a href="{{ route('home') }}#representatives">هیئت رئیسه و ساختار اداری</a></li><li><a href="{{ route('home') }}#friendship">آدرس و راهنمای مراجعه</a></li></ul></li>
        <li class="nav-item top-nav-item has-top-submenu"><button aria-expanded="false" class="nav-link top-nav-link" type="button">خدمات صنفی<span class="top-submenu-caret"></span></button><ul class="top-submenu"><li><a href="{{ route('home') }}#fractions">صدور پروانه کسب</a></li><li><a href="{{ route('home') }}#fractions">تمدید و انتقال پروانه</a></li><li><a href="{{ route('home') }}#commissions">فرم‌ها و درخواست‌ها</a></li></ul></li>
        <li class="nav-item top-nav-item has-top-submenu"><button aria-expanded="false" class="nav-link top-nav-link" type="button">اتحادیه‌ها<span class="top-submenu-caret"></span></button><ul class="top-submenu"><li><a href="{{ route('home') }}#commissions">فهرست اتحادیه‌های صنفی</a></li><li><a href="{{ route('guilds.show', 'gold-union') }}">رسته‌های شغلی</a></li><li><a href="{{ route('home') }}#friendship">اطلاعات تماس اتحادیه‌ها</a></li></ul></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('galleries.index') }}">گالری تصاویر</a></li><li class="nav-item"><a class="nav-link" href="{{ route('tourism.index') }}">گردشگری</a></li><li class="nav-item"><a class="nav-link" href="{{ route('home') }}#friendship">تماس با ما</a></li>
    @endif
@endif
