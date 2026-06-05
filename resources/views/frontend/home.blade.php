@extends('frontend.layouts.app')

@section('title', 'اتاق اصناف مرکز استان گلستان')
@section('meta_description', 'آخرین اخبار، اطلاعیه‌ها، خدمات، اتحادیه‌ها و جاذبه‌های گردشگری اتاق اصناف مرکز استان گلستان.')

@php
    $defaultImage = asset('assets/img/asnaf-gorgan-default.jpg');
    $assetImage = function (?string $path) use ($defaultImage) {
        if (blank($path)) {
            return $defaultImage;
        }

        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/'])) {
            return $path;
        }

        if (\Illuminate\Support\Str::startsWith($path, 'assets/')) {
            return asset($path);
        }

        return \Illuminate\Support\Facades\Storage::url($path);
    };
    $plain = fn ($value, $limit = 120) => \Illuminate\Support\Str::limit(trim(strip_tags((string) $value)), $limit);
    $homeUrl = route('home');
    $postsUrl = route('posts.index');
    $galleriesUrl = route('galleries.index');
    $tourismUrl = route('tourism.index');
    $videosUrl = route('videos.index');
    $guildsUrl = route('guilds.index');
    $contactUrl = route('contact.create');
    $systemsUrl = route('systems.index');
    $servicesUrl = route('electronic-services.index');
    $commissionsUrl = route('commissions.index');
    $complaintsUrl = route('complaints.create');

    $heroFallbacks = collect([
        ['title' => 'راهنمای صدور، تمدید و انتقال پروانه کسب برای فعالان صنفی گرگان', 'kicker' => 'خدمات صنفی', 'url' => $servicesUrl, 'image' => $defaultImage],
        ['title' => 'پیگیری شکایات مردمی و صیانت از حقوق مصرف‌کنندگان و واحدهای صنفی', 'kicker' => 'نظارت و بازرسی', 'url' => $complaintsUrl, 'image' => $defaultImage],
        ['title' => 'آخرین خبرها و اطلاعیه‌های اتاق اصناف مرکز استان گلستان', 'kicker' => 'اخبار اتاق', 'url' => $postsUrl, 'image' => $defaultImage],
    ]);
    $heroItems = ($heroPosts ?? collect())->take(3)->map(fn ($post) => [
        'title' => $post->title,
        'kicker' => $post->category_title ?? 'اخبار اتاق',
        'url' => route('posts.show', $post->slug),
        'image' => $post->featured_image_url,
    ])->values();
    if ($heroItems->isEmpty()) {
        $heroItems = ($importantAnnouncements ?? collect())->take(3)->map(fn ($announcement) => [
            'title' => $announcement->title,
            'kicker' => $announcement->category?->title ?? 'اطلاعیه',
            'url' => route('announcements.show', $announcement->slug),
            'image' => $assetImage($announcement->featured_image),
        ])->values();
    }
    $heroItems = $heroItems->isNotEmpty() ? $heroItems : $heroFallbacks;

    $sideNewsSource = ($latestPosts ?? collect())->map(fn ($post) => [
        'title' => $post->title,
        'url' => route('posts.show', $post->slug),
        'image' => $post->featured_image_url,
    ])->concat(($announcements ?? collect())->map(fn ($announcement) => [
        'title' => $announcement->title,
        'url' => route('announcements.show', $announcement->slug),
        'image' => $assetImage($announcement->featured_image),
    ]))->values();
    $sideItems = $sideNewsSource->take(2)->values();
    if ($sideItems->isEmpty()) {
        $sideItems = collect([
            ['title' => 'آدرس اتاق اصناف گرگان: خیابان مطهری جنوبی، روبروی پمپ بنزین، ساختمان اتاق اصناف', 'url' => $contactUrl, 'image' => $defaultImage],
            ['title' => 'تمرکز اتاق اصناف بر ساماندهی امور اتحادیه‌ها، آموزش متقاضیان و تسهیل خدمات صنفی', 'url' => $guildsUrl, 'image' => $defaultImage],
        ]);
    }

    $quickFallbacks = collect([
        ['title' => 'صدور و تمدید پروانه کسب', 'url' => $servicesUrl, 'children' => collect([['title' => 'راهنمای صدور پروانه کسب', 'url' => $servicesUrl], ['title' => 'تمدید و انتقال پروانه کسب', 'url' => $servicesUrl], ['title' => 'مدارک مورد نیاز متقاضیان', 'url' => $servicesUrl]])],
        ['title' => 'ثبت و پیگیری شکایات', 'url' => $complaintsUrl, 'children' => collect([['title' => 'ثبت شکایت صنفی', 'url' => $complaintsUrl], ['title' => 'گزارش تخلف واحد صنفی', 'url' => $complaintsUrl], ['title' => 'پیگیری نتیجه شکایت', 'url' => route('complaints.track')]])],
        ['title' => 'اتحادیه‌های صنفی استان گلستان', 'url' => $guildsUrl, 'children' => collect([['title' => 'فهرست اتحادیه‌ها', 'url' => $guildsUrl], ['title' => 'اطلاعات تماس اتحادیه‌ها', 'url' => $guildsUrl], ['title' => 'رسته‌های شغلی', 'url' => $guildsUrl]])],
        ['title' => 'سامانه‌ها و فرم‌ها', 'url' => $systemsUrl, 'children' => collect([['title' => 'سامانه نوین اصناف', 'url' => $systemsUrl], ['title' => 'فرم‌ها و بخشنامه‌ها', 'url' => $servicesUrl], ['title' => 'راهنمای خدمات الکترونیک', 'url' => $servicesUrl]])],
        ['title' => 'اخبار و اطلاعیه‌ها', 'url' => $postsUrl, 'children' => collect([['title' => 'آرشیو اخبار', 'url' => $postsUrl], ['title' => 'اطلاعیه‌ها', 'url' => route('announcements.index')], ['title' => 'چندرسانه‌ای', 'url' => '#multimedia']])],
        ['title' => 'ارتباط با اتاق', 'url' => $contactUrl, 'children' => collect([['title' => 'آدرس و تلفن تماس', 'url' => '#friendship'], ['title' => 'ارسال پیام', 'url' => $contactUrl], ['title' => 'راهنمای مراجعه حضوری', 'url' => '#friendship']])],
    ]);
    $quickItems = ($quickMenuItems ?? collect())->map(fn ($item) => [
        'title' => trim(($item->icon ? $item->icon.' ' : '').$item->title),
        'url' => $item->resolved_url ?: '#',
        'children' => $item->children->map(fn ($child) => ['title' => trim(($child->icon ? $child->icon.' ' : '').$child->title), 'url' => $child->resolved_url ?: '#']),
    ])->values();
    $quickItems = $quickItems->isNotEmpty() ? $quickItems : $quickFallbacks;

    $serviceFallbacks = collect([
        ['icon' => '📋', 'title' => 'نحوه صدور پروانه کسب', 'description' => 'راهنمای گام‌به‌گام دریافت پروانه کسب جدید و تشکیل پرونده صنفی برای متقاضیان', 'url' => $servicesUrl, 'label' => 'مشاهده راهنما ←'],
        ['icon' => '🔄', 'title' => 'نحوه تمدید پروانه کسب', 'description' => 'مراحل تمدید سالانه پروانه کسب، مدارک مورد نیاز و فرآیند بررسی در اتحادیه مربوطه', 'url' => $servicesUrl, 'label' => 'مشاهده راهنما ←'],
        ['icon' => '⚖️', 'title' => 'نحوه ثبت شکایت صنفی', 'description' => 'ثبت گزارش تخلفات صنفی، شکایات مردمی و نحوه پیگیری از طریق کمیسیون نظارت', 'url' => $complaintsUrl, 'label' => 'مشاهده راهنما ←'],
        ['icon' => '📁', 'title' => 'فرم‌ها و بخشنامه‌ها', 'description' => 'دانلود فرم‌های مورد نیاز، بخشنامه‌های جاری و اطلاعیه‌های جدید اتاق اصناف', 'url' => route('announcements.index'), 'label' => 'مشاهده فرم‌ها ←'],
        ['icon' => '💻', 'title' => 'سامانه نوین اصناف', 'description' => 'ورود به سامانه الکترونیک اصناف برای پیگیری پرونده و استعلام وضعیت پروانه کسب', 'url' => $systemsUrl, 'label' => 'ورود به سامانه ←'],
        ['icon' => '🎓', 'title' => 'آموزش احکام تجارت', 'description' => 'ثبت‌نام در دوره‌های آموزش احکام تجارت و کسب‌وکار مورد نیاز صدور پروانه کسب', 'url' => $servicesUrl, 'label' => 'ثبت‌نام دوره ←'],
    ]);
    $serviceItems = ($electronicServices ?? collect())->map(fn ($service) => [
        'icon' => $service->icon ?: '📋',
        'title' => $service->title,
        'description' => $service->short_description ?: $plain($service->body, 120),
        'url' => ($service->link_type === 'external' && filled($service->link)) ? $service->link : route('electronic-services.show', $service->slug),
        'target' => ($service->link_type === 'external' && filled($service->link)) ? ($service->target ?: '_blank') : '_self',
        'label' => 'مشاهده راهنما ←',
    ])->concat(($systems ?? collect())->map(fn ($system) => [
        'icon' => $system->icon ?: '💻',
        'title' => $system->title,
        'description' => $system->short_description ?: $plain($system->description, 120),
        'url' => filled($system->link) ? $system->link : route('systems.show', $system->slug),
        'target' => filled($system->link) ? ($system->target ?: '_blank') : '_self',
        'label' => 'ورود به سامانه ←',
    ]))->take(6)->values();
    $serviceItems = $serviceItems->isNotEmpty() ? $serviceItems : $serviceFallbacks;

    $adFallbacks = collect([
        ['title' => 'فضای تبلیغات شما', 'url' => '#', 'image' => $defaultImage, 'target' => '_self'],
        ['title' => 'فضای تبلیغات شما', 'url' => '#', 'image' => $defaultImage, 'target' => '_self'],
    ]);
    $adItems = ($homeAdvertisements ?? collect())->take(2)->map(fn ($ad) => ['title' => $ad->title ?: 'فضای تبلیغات شما', 'url' => $ad->link ?: '#', 'image' => $assetImage($ad->image), 'target' => $ad->target ?: '_self'])->values();
    $adItems = $adItems->isNotEmpty() ? $adItems : $adFallbacks;

    $unionPanels = collect([
        'rep-production' => ($productionUnions ?? collect()),
        'rep-distribution' => ($distributionUnions ?? collect()),
        'rep-service' => ($serviceUnions ?? collect()),
    ]);

    $commissionFallbacks = collect([
        ['icon' => '⚖️', 'title' => 'کمیسیون تشخیص', 'description' => 'نظارت بر عملکرد واحدهای صنفی، اجرای طرح‌های بازرسی دوره‌ای و رسیدگی به تخلفات صنفی در سطح شهرستان'],
        ['icon' => '🎓', 'title' => 'کمیسیون آموزش', 'description' => 'برنامه‌ریزی و برگزاری دوره‌های آموزش احکام تجارت و کسب‌وکار برای متقاضیان پروانه کسب و فعالان صنفی'],
        ['icon' => '🤝', 'title' => 'کمیسیون بازرسی', 'description' => 'رسیدگی به اختلافات صنفی میان اعضای اتحادیه‌ها و ارائه راهکارهای سازش و مصالحه'],
        ['icon' => '📊', 'title' => 'کمیسیون بازاریابی و توسعه', 'description' => 'حمایت از بازاریابی محصولات صنفی، توسعه بازارچه‌های محلی و برگزاری نمایشگاه‌های تخصصی'],
        ['icon' => '🏛', 'title' => 'کمیسیون صنایع دستی', 'description' => 'حمایت از هنرمندان و فعالان صنایع دستی، ساماندهی تولید و فروش محصولات سنتی و محلی'],
        ['icon' => '🌿', 'title' => 'کمیسیون گردشگری', 'description' => 'هماهنگی با فعالان حوزه گردشگری، هتل‌داران، رستوران‌داران و آژانس‌های مسافرتی شهرستان'],
        ['icon' => '💳', 'title' => 'کمیسیون مالی و اداری', 'description' => 'مدیریت منابع مالی، بودجه‌ریزی، امور اداری و پشتیبانی از فعالیت‌های اتاق اصناف شهرستان'],
        ['icon' => '📋', 'title' => 'کمیسیون امور صنفی', 'description' => 'پیگیری مسائل و نیازهای صنفی اتحادیه‌ها، صدور و تمدید پروانه‌های کسب و رسیدگی به درخواست‌ها'],
    ]);
    $commissionItems = ($commissions ?? collect())->take(8)->map(fn ($commission) => ['icon' => '⚖️', 'title' => $commission->title, 'description' => $plain($commission->description, 130), 'tasks' => $commission->activeTasks->take(3)->map(fn ($task) => ['title' => $task->title, 'description' => $task->description])->values(), 'url' => route('commissions.show', $commission->slug)])->values();
    $commissionItems = $commissionItems->isNotEmpty() ? $commissionItems : $commissionFallbacks;

    $tourismFallbacks = [
        'tourism-nature' => collect([['title' => 'جنگل النگدره', 'description' => 'یکی از زیباترین جاذبه‌های طبیعی استان گلستان در جنوب گرگان', 'badge' => 'طبیعت', 'alt' => 'جنگل النگدره'], ['title' => 'تالاب بین‌المللی گمیشان', 'description' => 'تالاب زیبا و زیستگاه پرندگان مهاجر در شمال استان گلستان', 'badge' => 'طبیعت', 'alt' => 'تالاب گمیشان'], ['title' => 'آبشار کبودوال', 'description' => 'آبشار زیبا و خنک در دل جنگل‌های انبوه استان گلستان', 'badge' => 'طبیعت', 'alt' => 'آبشار کبودوال'], ['title' => 'پارک ملی گلستان', 'description' => 'قدیمی‌ترین پارک ملی ثبت‌شده ایران با تنوع زیستی کم‌نظیر', 'badge' => 'طبیعت', 'alt' => 'پارک ملی گلستان']]),
        'tourism-historic' => collect([['title' => 'برج گنبد قابوس', 'description' => 'بلندترین برج آجری جهان و میراث جهانی یونسکو در استان گلستان', 'badge' => 'تاریخی', 'alt' => 'برج گنبد قابوس'], ['title' => 'دیوار دفاعی گرگان', 'description' => 'دیوار تاریخی گرگان (مار سرخ)، پس از دیوار چین طولانی‌ترین دیوار جهان', 'badge' => 'تاریخی', 'alt' => 'دیوار دفاعی گرگان'], ['title' => 'مسجد جامع گرگان', 'description' => 'مسجدی تاریخی از دوران سلجوقیان در مرکز بافت قدیم گرگان', 'badge' => 'تاریخی', 'alt' => 'مسجد جامع گرگان']]),
        'tourism-shop' => collect([['title' => 'بازار بزرگ گرگان', 'description' => 'مرکز خرید اصیل و سنتی گرگان با اصناف متنوع و محصولات محلی', 'badge' => 'خرید', 'alt' => 'بازار بزرگ گرگان'], ['title' => 'مرکز خرید گلستان', 'description' => 'مجتمع تجاری مدرن با فروشگاه‌های متنوع و خدمات رفاهی', 'badge' => 'خرید', 'alt' => 'پاساژ گلستان'], ['title' => 'هتل شیرخان گرگان', 'description' => 'هتل مجهز و مدرن با دسترسی آسان به مراکز دیدنی شهر گرگان', 'badge' => 'اقامت', 'alt' => 'هتل شیرخان']]),
    ];
    $tourismPanels = collect([
        'tourism-nature' => ($tourismNature ?? collect()),
        'tourism-historic' => ($tourismHistoric ?? collect()),
        'tourism-shop' => ($tourismShop ?? collect()),
    ])->map(fn ($places, $key) => $places->isNotEmpty() ? $places : $tourismFallbacks[$key]);

    $videoFallbacks = collect(['گزارش تصویری از خدمات اتاق اصناف گرگان به کسبه شهرستان', 'راهنمای مراحل صدور و تمدید پروانه کسب', 'آموزش احکام تجارت برای متقاضیان', 'بازدید میدانی بازرسان از واحدهای صنفی گرگان', 'نشست هماهنگی اتحادیه‌های صنفی شهرستان گرگان']);
    $galleryFallbacks = collect(['نمایی از ساختمان و مراجعه حضوری فعالان صنفی', 'جلسه هم‌اندیشی اتحادیه‌های صنفی استان گلستان', 'ارائه خدمات مشاوره‌ای به متقاضیان پروانه کسب', 'برگزاری دوره آموزشی احکام تجارت و کسب‌وکار', 'پیگیری طرح‌های نظارتی بازار در شهرستان گرگان', 'بخشنامه‌ها و دستورالعمل‌های جدید صنفی', 'بازار سنتی گرگان و اصناف قدیمی شهر', 'نمایشگاه صنایع دستی و سوغات استان گلستان']);
@endphp

@section('content')
<main>
<section class="hero-section site-container">
<div class="hero-grid">
<nav aria-label="دسترسی سریع" class="quick-menu">
<ul class="quick-menu-list">
@foreach($quickItems as $item)
<li class="quick-menu-item">
<a class="quick-menu-link" href="{{ $item['url'] }}">{{ $item['title'] }}</a>
@if(($item['children'] ?? collect())->isNotEmpty())
<ul class="quick-submenu">
@foreach($item['children'] as $child)
<li><a href="{{ $child['url'] }}">{{ $child['title'] }}</a></li>
@endforeach
</ul>
@endif
</li>
@endforeach
</ul>
</nav>
<div aria-label="اسلایدر خبرهای اصلی" class="hero-slider swiper">
<div class="swiper-wrapper">
@foreach($heroItems as $item)
<article class="news-card news-card-main swiper-slide">
<a href="{{ $item['url'] }}">
<img alt="{{ $item['title'] }}" src="{{ $item['image'] }}"/>
<div class="news-overlay"></div>
<div class="news-content">
<span class="news-kicker">{{ $item['kicker'] }}</span>
<h1>{{ $item['title'] }}</h1>
</div>
</a>
</article>
@endforeach
</div>
<button aria-label="خبر بعدی" class="hero-slider-arrow hero-slider-next" type="button"></button>
<button aria-label="خبر قبلی" class="hero-slider-arrow hero-slider-prev" type="button"></button>
<div class="hero-slider-pagination"></div>
</div>
<div aria-label="خبرهای کناری" class="side-news">
@foreach($sideItems as $item)
<article class="news-card side-card">
<a href="{{ $item['url'] }}">
<img alt="{{ $item['title'] }}" src="{{ $item['image'] }}"/>
<div class="news-overlay"></div>
<div class="news-content"><h2>{{ $item['title'] }}</h2></div>
</a>
</article>
@endforeach
</div>
</div>
</section>

<section class="site-container howto-section">
<div class="section-heading section-heading-centered">
<h2>خدمات الکترونیک صنفی</h2>
<p>نحوه انجام خدمات و دریافت مجوزها و ثبت درخواست‌ها</p>
</div>
<div class="howto-grid">
@foreach($serviceItems as $item)
<a class="howto-card" href="{{ $item['url'] }}" target="{{ $item['target'] ?? '_self' }}">
<div class="howto-icon">{{ $item['icon'] }}</div>
<h3>{{ $item['title'] }}</h3>
<p>{{ $item['description'] }}</p>
<span class="howto-link">{{ $item['label'] }}</span>
</a>
@endforeach
</div>
</section>

<section class="home-ad-banners site-container">
@foreach($adItems as $ad)
<a class="ad-banner" href="{{ $ad['url'] }}" target="{{ $ad['target'] }}">
<img alt="تبلیغات" src="{{ $ad['image'] }}"/>
<div class="ad-banner-overlay"></div>
<div class="ad-banner-text">{{ $ad['title'] }}</div>
</a>
@endforeach
</section>

<section class="multimedia-section" id="multimedia">
<div class="site-container">
<div class="media-header" data-tab-group="media">
<h2>چندرسانه‌ای</h2>
<div class="media-tab-group">
<button class="media-tab active" data-tab-target="media-video" type="button">ویدیوها</button>
<button class="media-tab" data-tab-target="media-image" type="button">تصاویر</button>
</div>
</div>
<div class="tab-panels" data-tab-panels="media">
<div class="tab-panel active" data-tab-panel="media-video">
      <div class="media-grid">
@forelse(($latestVideos ?? collect())->take(5) as $video)
      <a href="{{ route('videos.show', $video->slug) }}" class="media-card {{ $loop->first ? 'media-card-lg' : '' }}">
        <img alt="{{ $video->title }}" src="{{ $assetImage($video->cover_image) }}"/>
        <div class="media-card-overlay"></div>
        <span class="media-play-btn"></span>
        <div class="media-card-footer">
          <h3>{{ $video->title }}</h3>
        </div>
      </a>
@empty
@foreach($videoFallbacks as $title)
      <a href="{{ $videosUrl }}" class="media-card {{ $loop->first ? 'media-card-lg' : '' }}">
        <img alt="{{ $title }}" src="{{ $defaultImage }}"/>
        <div class="media-card-overlay"></div>
        <span class="media-play-btn"></span>
        <div class="media-card-footer">
          <h3>{{ $title }}</h3>
        </div>
      </a>
@endforeach
@endforelse
      </div>
      <a class="media-view-all" href="{{ $videosUrl }}">مشاهده همه ویدیوها</a>
</div>
<div class="tab-panel" data-tab-panel="media-image">
<div class="media-grid">
@forelse(($latestGalleries ?? collect())->take(8) as $gallery)
<a href="{{ route('galleries.show', $gallery->slug) }}" class="media-card">
<img alt="{{ $gallery->title }}" src="{{ $gallery->cover_image_url }}"/>
<div class="media-card-overlay"></div>
<div class="media-card-footer">
<h3>{{ $gallery->title }}</h3>
</div>
</a>
@empty
@foreach($galleryFallbacks as $title)
<a href="{{ $galleriesUrl }}" class="media-card">
<img alt="{{ $title }}" src="{{ $defaultImage }}"/>
<div class="media-card-overlay"></div>
<div class="media-card-footer">
<h3>{{ $title }}</h3>
</div>
</a>
@endforeach
@endforelse
</div>
<a class="media-view-all" href="{{ $galleriesUrl }}">مشاهده همه تصاویر</a>
</div>
</div>
</div>
</section>

<section class="price-ticker-section site-container" id="prices">
<div class="price-ticker-card">
<div class="price-ticker-heading"><span>💰</span><div><h2>قیمت روز طلا و ارز</h2><p>مقادیر از تنظیمات سایت خوانده می‌شود و در صورت نبود داده با خط تیره نمایش داده می‌شود.</p></div></div>
<div class="price-ticker-grid">
@foreach(($priceItems ?? collect()) as $price)
<div class="price-ticker-item">
<span>{{ $price['label'] }}</span>
<strong>{{ $price['value'] }}</strong>
<small>{{ $price['unit'] }} @if(filled($price['trend'] ?? null)) · {{ $price['trend'] }} @endif</small>
</div>
@endforeach
</div>
</div>
</section>


<section class="representatives-section section-white" id="representatives" data-union-ajax-url="{{ route('guilds.ajax-search') }}">
<div class="site-container">
<div class="section-heading">
<h2>اتحادیه‌های صنفی استان گلستان</h2>
<div aria-label="نماینده‌ها" class="tabs" data-tab-group="representatives" role="tablist">
<button class="tab-pill active" data-tab-target="rep-production" type="button">اتحادیه‌های تولیدی</button>
<button class="tab-pill" data-tab-target="rep-distribution" type="button">اتحادیه‌های توزیعی</button>
<button class="tab-pill" data-tab-target="rep-service" type="button">اتحادیه‌های خدماتی</button>
</div>
</div>
<div class="tab-panels" data-tab-panels="representatives">
@foreach(['rep-production' => ['اتحادیه‌های تولیدی شهرستان گرگان', 'map-img'], 'rep-distribution' => ['اتحادیه‌های توزیعی شهرستان گرگان', 'map-img muted-map'], 'rep-service' => ['اتحادیه‌های خدماتی شهرستان گرگان', 'map-img faded-map']] as $panel => $map)
<div class="tab-panel {{ $loop->first ? 'active' : '' }}" data-tab-panel="{{ $panel }}">
<div class="representative-layout">
<div class="representative-map">
<button class="soft-button map-badge">{{ $map[0] }}</button>
<img alt="تصویر پیش‌فرض اتاق اصناف مرکز استان گلستان" class="{{ $map[1] }}" src="{{ $defaultImage }}"/>
</div>
<aside class="people-panel" data-search-area="">
<div class="searchbox"><span class="search-icon"></span><input data-union-ajax-input="" data-union-type="{{ str_replace('rep-', '', $panel) }}" placeholder="جستجوی سریع اتحادیه..." type="search"/></div>
<div class="people-scroll-wrap">
<ul class="person-list" data-union-results="{{ $panel }}">
@forelse($unionPanels[$panel] as $union)
<li class="union-home-item"><a href="{{ route('guilds.show', $union->slug) }}" class="d-flex align-items-center gap-2 text-decoration-none"><span class="person-avatar avatar-{{ ($loop->iteration % 6) + 1 }}"></span><div><strong>{{ $union->display_title }}</strong><small>{{ $union->short_description ?: $union->manager_name ?: $union->union_type_label }}</small></div></a><div class="union-home-actions"><a href="{{ route('complaints.create', ['union_id' => $union->id]) }}">ثبت شکایت</a>@foreach(($union->social_links ?? []) as $network => $link)@if(filled($link))<a href="{{ $link }}" target="_blank" rel="noopener">{{ $network }}</a>@endif @endforeach</div></li>
@empty
<li><span class="person-avatar avatar-1"></span><div><strong>اتحادیه‌ای ثبت نشده است</strong><small>لطفاً از پنل مدیریت اتحادیه جدید ثبت کنید.</small></div></li>
@endforelse
</ul>
<div class="union-ajax-status" data-union-status="{{ $panel }}" hidden></div>
</div>
</aside>
</div>
</div>
@endforeach
</div>
</div>
</section>

<section class="commissions-section ds-tint-block office-services-section" id="commissions">
<div class="site-container">
<div class="section-heading">
<h2>خدمات اتاق</h2>
<a class="tab-pill" href="{{ $servicesUrl }}">مشاهده همه خدمات</a>
</div>
<div class="commission-card"><div class="commission-grid compact-grid">
@foreach($serviceItems as $item)
<a class="commission-item service-color-{{ ($loop->iteration % 4) + 1 }}" href="{{ $item['url'] }}" target="{{ $item['target'] ?? '_self' }}"><strong>{{ $item['title'] }}</strong><span>{{ $item['description'] }}</span></a>
@endforeach
</div></div>
</div>
</section>
<section class="commissions-real" id="commissions-real">
<div class="site-container">
<div class="section-heading section-heading-centered">
<h2>کمیسیون‌های اتاق اصناف مرکز استان گلستان</h2>
<p>کمیسیون‌های تخصصی، پایین‌تر از خدمات اتاق نمایش داده شده‌اند و وظایف هر کمیسیون به‌صورت داینامیک از دیتابیس خوانده می‌شود.</p>
</div>
<div class="comreal-grid">
@foreach($commissionItems as $item)
<a href="{{ $item['url'] ?? $commissionsUrl }}" class="comreal-card">
<div class="comreal-icon">{{ $item['icon'] }}</div>
<h3>{{ $item['title'] }}</h3>
<p>{{ $item['description'] }}</p>
@if(($item['tasks'] ?? collect())->isNotEmpty())
<ul class="commission-task-mini">@foreach($item['tasks'] as $task)<li>{{ $task['title'] }}</li>@endforeach</ul>
@else
<ul class="commission-task-mini"><li>فضای ثبت وظایف کمیسیون در پنل مدیریت آماده است.</li></ul>
@endif
</a>
@endforeach
</div>
</div>
</section>

<section class="fractions-section section-gray" id="fractions">
<div class="site-container">
<div class="section-heading">
<h2>موضوعات پیگیری اصناف</h2>
</div>
<div class="fraction-grid">
@foreach(['تسهیل صدور پروانه کسب','کاهش زمان پاسخگویی','راهنمای تکمیل مدارک','شفاف‌سازی مراحل اداری','به‌روزرسانی اطلاعات واحدها','پیگیری درخواست‌های متقاضیان','ساماندهی رسته‌های شغلی','همکاری با اتحادیه‌ها','اطلاع‌رسانی بخشنامه‌ها','مدیریت مراجعات حضوری','ثبت و اصلاح پرونده‌ها','پشتیبانی کسب‌وکارهای کوچک','حمایت از تولید و فروش محلی','توسعه خدمات الکترونیکی','تعامل با دستگاه‌های اجرایی','افزایش رضایت مراجعه‌کنندگان','پاسخگویی به اصناف','تقویت اعتماد عمومی'] as $fraction)
<a href="{{ $servicesUrl }}" class="fraction-link">{{ $fraction }}</a>
@endforeach
</div>
</div>
</section>

<section class="friendship-section section-white" id="friendship">
<div class="site-container">
<div class="section-heading friendship-heading"><h2>ارتباط با اتاق و دستگاه‌های همکار</h2><a class="tab-pill" href="{{ $contactUrl }}">راهنمای تماس</a></div>
<div class="friendship-layout">
<div class="world-map-wrap">
<img alt="تصویر پیش‌فرض اتاق اصناف مرکز استان گلستان" class="world-map-img" src="{{ $defaultImage }}"/>
</div>
<aside class="friend-list">
<div class="friend-scroll-wrap">
<ul>
@forelse($orgLinks ?? collect() as $link)
<li><a href="{{ $link->url ?: '#' }}" target="{{ $link->target ?? '_self' }}" class="text-decoration-none" @if(($link->target ?? '_self') === '_blank') rel="noopener" @endif>@if($link->icon)<span>{{ $link->icon }}</span>@endif <strong>{{ $link->title }}</strong>@if($link->description)<small>{{ $link->description }}</small>@endif</a></li>
@empty
<li><a href="{{ $contactUrl }}">اتاق اصناف مرکز استان گلستان؛ مشاهده اطلاعات تماس و راهنمای مراجعه</a></li>
@endforelse
</ul>
</div>
</aside>
</div>
</div>
</section>

<section class="tourism-section" id="tourism">
<div class="site-container">
<div class="section-heading">
<h2>گردشگری گرگان و گلستان</h2>
<div aria-label="دسته‌بندی گردشگری" class="tabs" data-tab-group="tourism" role="tablist">
<button class="tab-pill active" data-tab-target="tourism-nature" type="button">طبیعت‌گردی</button>
<button class="tab-pill" data-tab-target="tourism-historic" type="button">تاریخی</button>
<button class="tab-pill" data-tab-target="tourism-shop" type="button">بازار و خرید</button>
</div>
</div>
<div class="tab-panels" data-tab-panels="tourism">
@foreach($tourismPanels as $panel => $places)
<div class="tab-panel {{ $loop->first ? 'active' : '' }}" data-tab-panel="{{ $panel }}">
<div class="tourism-grid">
@foreach($places as $place)
@php
    $isModel = is_object($place);
    $placeTitle = $isModel ? $place->title : $place['title'];
    $placeDesc = $isModel ? (\Illuminate\Support\Str::limit($place->home_description, 120) ?: 'توضیحی برای این جاذبه ثبت نشده است.') : $place['description'];
    $placeBadge = $isModel ? $place->home_badge : $place['badge'];
    $placeAlt = $isModel ? $place->title : $place['alt'];
    $placeImage = $isModel ? $place->home_image_url : $defaultImage;
    $placeUrl = $isModel ? route('tourism.show', $place->slug) : $tourismUrl;
@endphp
<div class="tourism-card">
<a href="{{ $placeUrl }}">
<div class="tourism-img-wrap">
<img alt="{{ $placeAlt }}" src="{{ $placeImage }}"/>
<div class="tourism-badge">{{ $placeBadge }}</div>
</div>
<div class="tourism-card-body">
<h3>{{ $placeTitle }}</h3>
<p>{{ $placeDesc }}</p>
</div>
</a>
</div>
@endforeach
</div>
</div>
@endforeach
</div>
</div>
</section>


</main>
@endsection
