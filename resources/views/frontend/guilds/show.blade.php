@extends('frontend.layouts.app')

@section('title', ($union->display_title ?? $union->title ?? 'اتحادیه صنفی').' | اتاق اصناف مرکز استان گلستان')
@section('meta_description', $union->meta_description ?? $union->short_description ?? 'اطلاعات اتحادیه صنفی، اعضا، کمیسیون‌ها، اخبار، اطلاعیه‌ها و راه‌های تماس')

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
    $plain = fn ($value, $limit = 130) => \Illuminate\Support\Str::limit(trim(strip_tags((string) $value)), $limit);
    $heroImage = $assetImage($union->cover_image);
    $logoImage = $union->logo ? $assetImage($union->logo) : null;
    $managerInitial = mb_substr($union->manager_name ?: $union->display_title ?: 'ا', 0, 1);
    $socialLinks = collect($union->social_link_items ?? []);
    $sliderItems = ($sliderPosts ?? collect())->map(fn ($post) => [
        'title' => $post->title,
        'date' => jalali_date($post->published_at ?: $post->created_at),
        'url' => route('posts.show', $post->slug),
        'image' => $post->featured_image_url,
    ])->values();
    $sliderItems = $sliderItems->isNotEmpty() ? $sliderItems : $fallbacks['slider'];
    $articleFallbacks = $fallbacks['articles'];
    $priceRows = ($prices ?? collect())->map(fn ($price) => [
        'title' => $price->title,
        'amount' => filled($price->amount) ? number_format((float) $price->amount) : '—',
        'type' => $price->type,
        'unit' => $price->unit,
        'source' => $price->source ?: 'سامانه قیمت‌ها',
        'date' => jalali_date($price->published_at ?: $price->updated_at),
    ])->values();
    $priceRows = $priceRows->isNotEmpty() ? $priceRows : $fallbacks['prices'];
@endphp

@section('content')
<div class="guild-hero">
    <img alt="{{ $union->display_title }}" class="guild-hero-bg" src="{{ $heroImage }}"/>
    <div class="site-container guild-hero-content">
        <div class="guild-hero-logo">
            @if($logoImage)
                <img src="{{ $logoImage }}" alt="لوگوی {{ $union->display_title }}" class="guild-logo-img">
            @else
                {{ mb_substr($union->display_title ?: 'ا', 0, 1) }}
            @endif
        </div>
        <div class="guild-hero-text">
            <nav class="breadcrumb-nav guild-hero-breadcrumb"><a href="{{ route('home') }}">خانه</a><span class="breadcrumb-sep">/</span><a href="{{ route('guilds.index') }}">اتحادیه‌ها</a><span class="breadcrumb-sep">/</span><span>{{ $union->display_title }}</span></nav>
            <h1>{{ $union->display_title }}</h1>
            <p>{{ $union->short_description ?: 'اتحادیه فعال زیرمجموعه اتاق اصناف مرکز استان گلستان' }}</p>
            <div class="guild-hero-stats"><span>اعضا: <strong>{{ $members->count() }}</strong></span><span>کمیسیون‌ها: <strong>{{ $union->activeCommissions->count() ?: $fallbacks['commissions']->count() }}</strong></span><span>آخرین بروزرسانی: <strong>{{ jalali_date($union->updated_at) }}</strong></span></div>
        </div>
    </div>
</div>

<main>
    <div class="site-container guild-layout">
        <aside class="guild-side-nav">
            <h4>راهنمای سریع</h4>
            <ul>
                <li><a href="#guild-members">رییس و هیئت مدیره</a></li>
                <li><a href="#guild-commissions">کمیسیون‌ها</a></li>
                <li><a href="#guild-rules">قوانین</a></li>
                <li><a href="#guild-slider">اسلایدر خبری</a></li>
                <li><a href="#guild-news">اخبار و مقاله‌ها</a></li>
                <li><a href="#guild-prices">نرخ‌نامه</a></li>
                <li><a href="#guild-complaint">ثبت شکایت</a></li>
                <li><a href="#guild-minutes">صورتجلسه‌ها</a></li>
                <li><a href="#guild-edu">آموزش</a></li>
                <li><a href="#guild-announce">اطلاعیه‌ها</a></li>
                <li><a href="#guild-gallery">گالری و ویدیو</a></li>
                <li><a href="#guild-search">جستجو</a></li>
                <li><a href="#guild-contact">تماس با ما</a></li>
            </ul>
        </aside>

        <div>
            <section class="guild-section guild-section-alt" id="guild-members" style="padding-top:0">
                <h3 class="guild-section-title">رییس {{ $union->display_title }}</h3>
                <div class="guild-head-card">
                    <div class="guild-head-avatar">{{ $managerInitial }}</div>
                    <div class="guild-head-info">
                        <strong>{{ $union->manager_name ?: 'مدیر اتحادیه' }}</strong>
                        <span>رییس {{ $union->display_title }}</span>
                        <p>{{ $union->description ?: 'اطلاعات این اتحادیه از پایگاه داده خوانده می‌شود و پس از تکمیل در پنل مدیریت، توضیحات کامل در همین بخش نمایش داده خواهد شد.' }}</p>
                        <div class="guild-head-contact"><a href="tel:{{ preg_replace('/[^0-9+]/', '', (string) $union->phone) }}">تماس با رییس اتحادیه</a><a href="#guild-contact">اطلاعات تماس</a></div>
                    </div>
                </div>
            </section>

            <section class="guild-section guild-section-alt" id="guild-board">
                <h3 class="guild-section-title">اعضای هیئت مدیره اتحادیه</h3>
                <div class="guild-members-grid">
                    @forelse(($boardMembers->isNotEmpty() ? $boardMembers : collect()) as $member)
                        <div class="guild-member-card"><div class="member-avatar">{{ mb_substr($member->full_name, 0, 1) }}</div><strong>{{ $member->full_name }}</strong><small>{{ $member->business_name ?: $member->membership_code ?: 'عضو اتحادیه' }}</small></div>
                    @empty
                        @foreach($fallbacks['members'] as $member)
                            <div class="guild-member-card"><div class="member-avatar">{{ mb_substr($member['name'], 0, 1) }}</div><strong>{{ $member['name'] }}</strong><small>{{ $member['position'] }}</small></div>
                        @endforeach
                    @endforelse
                </div>
            </section>

            <section class="guild-section guild-section-alt" id="guild-commissions">
                <h3 class="guild-section-title">کمیسیون‌ها و وظایف اتحادیه</h3>
                <div class="guild-commission-list">
                    @forelse($union->activeCommissions as $commission)
                        <div class="guild-commission-item guild-commission-dynamic"><div class="com-num">{{ $loop->iteration }}</div><div><strong>{{ $commission->title }}</strong><small>{{ $commission->description ?: 'توضیحی برای این کمیسیون ثبت نشده است.' }}</small><ul class="guild-task-list">@forelse($commission->activeTasks as $task)<li>{{ $task->title }}</li>@empty<li>وظیفه‌ای برای این کمیسیون ثبت نشده است.</li>@endforelse</ul></div></div>
                    @empty
                        @foreach($fallbacks['commissions'] as $commission)
                            <div class="guild-commission-item guild-commission-dynamic"><div class="com-num">{{ $loop->iteration }}</div><div><strong>{{ $commission['title'] }}</strong><small>{{ $commission['description'] }}</small><ul class="guild-task-list">@foreach($commission['tasks'] as $task)<li>{{ $task }}</li>@endforeach</ul></div></div>
                        @endforeach
                    @endforelse
                </div>
            </section>

            <section class="guild-section guild-section-alt" id="guild-rules">
                <h3 class="guild-section-title">قوانین و دستورالعمل‌ها</h3>
                <div class="guild-2col">
                    <div class="guild-rules-list">
                        @forelse($rules->take(3) as $rule)
                            <a class="guild-rule-item" href="{{ route('announcements.show', $rule->slug) }}"><div class="rule-icon">📋</div><div><strong>{{ $rule->title }}</strong><small>{{ $rule->excerpt ?: $plain($rule->body, 90) }}</small></div></a>
                        @empty
                            @foreach($fallbacks['rules']->take(3) as $rule)
                                <a class="guild-rule-item" href="{{ $rule['url'] }}"><div class="rule-icon">📋</div><div><strong>{{ $rule['title'] }}</strong><small>{{ $rule['excerpt'] }}</small></div></a>
                            @endforeach
                        @endforelse
                    </div>
                    <div class="guild-rules-list">
                        @forelse($rules->slice(3, 3) as $rule)
                            <a class="guild-rule-item" href="{{ route('announcements.show', $rule->slug) }}"><div class="rule-icon">📋</div><div><strong>{{ $rule->title }}</strong><small>{{ $rule->excerpt ?: $plain($rule->body, 90) }}</small></div></a>
                        @empty
                            @foreach($fallbacks['rules']->slice(1, 3) as $rule)
                                <a class="guild-rule-item" href="{{ $rule['url'] }}"><div class="rule-icon">📋</div><div><strong>{{ $rule['title'] }}</strong><small>{{ $rule['excerpt'] }}</small></div></a>
                            @endforeach
                        @endforelse
                    </div>
                </div>
            </section>

            <section class="guild-section" id="guild-slider">
                <h3 class="guild-section-title">اسلایدر خبری اتحادیه</h3>
                <div class="guild-news-slider swiper">
                    <div class="swiper-wrapper">
                        @foreach($sliderItems as $item)
                            <a class="swiper-slide" href="{{ $item['url'] }}"><img alt="{{ $item['title'] }}" src="{{ $item['image'] }}"/><div class="slide-overlay"></div><div class="slide-text"><h3>{{ $item['title'] }}</h3><span>{{ $item['date'] }}</span></div></a>
                        @endforeach
                    </div>
                    <div class="slider-arrows"><button class="guild-slider-prev" type="button">‹</button><button class="guild-slider-next" type="button">›</button></div>
                    <div class="swiper-pagination"></div>
                </div>
            </section>

            <section class="guild-section" id="guild-news">
                <h3 class="guild-section-title">آخرین اخبار {{ $union->display_title }}</h3>
                <div class="guild-article-list">
                    @forelse($posts as $post)
                        <a class="guild-article-item" href="{{ route('posts.show', $post->slug) }}"><img alt="{{ $post->title }}" src="{{ $post->featured_image_url }}"/><div><h4>{{ $post->title }}</h4><p>{{ $post->excerpt ?: $plain($post->body) }}</p><span class="item-date">{{ jalali_date($post->published_at ?: $post->created_at) }}</span></div></a>
                    @empty
                        <div class="guild-info-card"><h4>خبری ثبت نشده است</h4><p>آخرین خبرهای این اتحادیه پس از انتشار در پنل مدیریت نمایش داده می‌شود.</p></div>
                    @endforelse
                </div>
            </section>

            <section class="guild-section" id="guild-articles">
                <h3 class="guild-section-title">مقاله‌ها</h3>
                <div class="guild-3col">
                    @forelse($articles as $article)
                        <div class="archive-card"><a href="{{ route('posts.show', $article->slug) }}"><img alt="{{ $article->title }}" class="archive-card-img" src="{{ $article->featured_image_url }}"/><div class="archive-card-body"><h2>{{ $article->title }}</h2><p>{{ $article->excerpt ?: $plain($article->body) }}</p><span class="card-date">{{ jalali_date($article->published_at ?: $article->created_at) }}</span></div></a></div>
                    @empty
                        @foreach($articleFallbacks as $article)
                            <div class="archive-card"><a href="{{ $article['url'] }}"><img alt="{{ $article['title'] }}" class="archive-card-img" src="{{ $article['image'] }}"/><div class="archive-card-body"><h2>{{ $article['title'] }}</h2><p>{{ $article['excerpt'] }}</p><span class="card-date">{{ $article['date'] }}</span></div></a></div>
                        @endforeach
                    @endforelse
                </div>
            </section>

            <section class="guild-section guild-section-alt" id="guild-prices">
                <h3 class="guild-section-title">نرخ‌نامه و قیمت‌ها</h3>
                <div class="price-table-wrap"><table class="price-table"><thead><tr><th>عنوان</th><th>قیمت</th><th>نوع</th><th>تاریخ بروزرسانی</th></tr></thead><tbody>@foreach($priceRows as $price)<tr><td>{{ $price['title'] }}</td><td>{{ $price['amount'] }} {{ $price['unit'] }}</td><td>{{ $price['source'] ?: $price['type'] }}</td><td>{{ $price['date'] }}</td></tr>@endforeach</tbody></table></div>
            </section>

            <section class="guild-section guild-section-alt" id="guild-complaint">
                <h3 class="guild-section-title">ثبت شکایت صنفی</h3>
                <div class="guild-2col"><div class="guild-info-card"><h4>نحوه ثبت شکایت</h4><p>ثبت شکایت برای همه اتحادیه‌های فعال امکان‌پذیر است. شکایت مرتبط با {{ $union->display_title }} از طریق فرم الکترونیکی ثبت و با کد رهگیری قابل پیگیری خواهد بود.</p><ul><li>انتخاب اتحادیه در فرم شکایت</li><li>ثبت مشخصات، موضوع و شرح شکایت</li><li>دریافت کد رهگیری و پیگیری وضعیت</li></ul></div><div class="guild-complaint-cta"><strong>ثبت شکایت آنلاین</strong><a class="tab-pill active" href="{{ route('complaints.create', $union->id) }}">ثبت شکایت جدید</a><a class="tab-pill" href="{{ route('complaints.track') }}">پیگیری شکایت قبلی</a></div></div>
            </section>

            <section class="guild-section guild-section-alt" id="guild-minutes">
                <h3 class="guild-section-title">صورتجلسه‌های اجرایی</h3>
                <div class="guild-minutes-list">
                    @forelse($minutes as $minute)
                        <div class="guild-minute-item"><div class="minute-info"><strong>{{ $minute->title }}</strong><span>{{ jalali_date($minute->published_at ?: $minute->created_at) }}</span></div><a class="minute-dl" href="{{ $assetImage($minute->attachment) }}" target="_blank" rel="noopener">دانلود فایل</a></div>
                    @empty
                        <div class="guild-info-card"><h4>{{ $fallbacks['minutes_empty'] }}</h4><p>صورتجلسه‌ها پس از بارگذاری در بخش اطلاعیه‌ها یا پیوست‌ها نمایش داده می‌شوند.</p></div>
                    @endforelse
                </div>
            </section>

            <section class="guild-section guild-section-alt" id="guild-edu">
                <h3 class="guild-section-title">آموزش</h3>
                <div class="guild-4col">
                    @forelse($trainings as $training)
                        <a class="guild-edu-item" href="{{ ($training->link_type === 'external' && filled($training->link)) ? $training->link : route('electronic-services.show', $training->slug) }}" target="{{ ($training->link_type === 'external' && filled($training->link)) ? ($training->target ?: '_blank') : '_self' }}"><div class="edu-icon">{{ $training->icon ?: '📚' }}</div><strong>{{ $training->title }}</strong><span>{{ $training->short_description ?: $plain($training->body, 80) }}</span></a>
                    @empty
                        @foreach($fallbacks['trainings'] as $training)
                            <a class="guild-edu-item" href="{{ $training['url'] }}"><div class="edu-icon">{{ $training['icon'] }}</div><strong>{{ $training['title'] }}</strong><span>{{ $training['description'] }}</span></a>
                        @endforeach
                    @endforelse
                </div>
            </section>

            <section class="guild-section guild-section-alt" id="guild-announce">
                <h3 class="guild-section-title">اطلاعیه و بخشنامه‌ها</h3>
                <div class="guild-announce-list">
                    @forelse($announcements as $announcement)
                        <a class="guild-announce-item" href="{{ route('announcements.show', $announcement->slug) }}"><div class="announce-badge"></div><strong>{{ $announcement->title }}</strong><span>{{ jalali_date($announcement->published_at ?: $announcement->created_at) }}</span></a>
                    @empty
                        <div class="guild-info-card"><h4>{{ $fallbacks['announcements_empty'] }}</h4><p>پس از ثبت اطلاعیه یا بخشنامه در پنل مدیریت، این بخش به‌صورت خودکار تکمیل می‌شود.</p></div>
                    @endforelse
                </div>
            </section>

            <section class="guild-section" id="guild-gallery">
                <div class="media-header" data-tab-group="guild-gallery"><h3 class="guild-section-title mb-0">گالری تصاویر و ویدیو</h3><div class="media-tab-group"><button class="media-tab active" data-tab-target="guild-gallery-images" type="button">تصاویر</button><button class="media-tab" data-tab-target="guild-gallery-videos" type="button">ویدیوها</button></div></div>
                <div class="tab-panels" data-tab-panels="guild-gallery">
                    <div class="tab-panel active" data-tab-panel="guild-gallery-images"><div class="guild-gallery-grid">@forelse($galleries as $gallery)<a class="guild-gallery-item" href="{{ route('galleries.show', $gallery->slug) }}"><img alt="{{ $gallery->title }}" src="{{ $gallery->cover_image_url }}"><span>{{ $gallery->title }}</span></a>@empty<div class="guild-info-card"><h4>{{ $fallbacks['gallery_empty'] }}</h4></div>@endforelse</div><div class="guild-gallery-more"><a href="{{ route('galleries.index') }}">مشاهده همه تصاویر</a></div></div>
                    <div class="tab-panel" data-tab-panel="guild-gallery-videos"><div class="guild-gallery-grid">@forelse($videos as $video)<a class="guild-gallery-item video" href="{{ route('videos.show', $video->slug) }}"><img alt="{{ $video->title }}" src="{{ $assetImage($video->cover_image) }}"><span>{{ $video->title }}</span></a>@empty<div class="guild-info-card"><h4>{{ $fallbacks['gallery_empty'] }}</h4></div>@endforelse</div><div class="guild-gallery-more"><a href="{{ route('videos.index') }}">مشاهده همه ویدیوها</a></div></div>
                </div>
            </section>

            <section class="guild-section guild-section-alt" id="guild-search">
                <h3 class="guild-section-title">جستجو در محتوای اتحادیه</h3>
                <p class="guild-search-desc">برای جستجوی کامل در خبرها، اطلاعیه‌ها، اتحادیه‌ها و خدمات سایت از فرم زیر استفاده کنید.</p>
                <form class="guild-search-box" action="{{ route('search') }}" method="GET"><input name="q" value="{{ request('q') }}" placeholder="عبارت مورد نظر؛ مثل {{ $union->display_title }}، شکایت، آموزش..." type="search"><button type="submit">جستجو</button></form>
            </section>

            <section class="guild-section" id="guild-contact">
                <h3 class="guild-section-title">تماس با اتحادیه و شبکه‌های اجتماعی</h3>
                <div class="guild-contact-grid"><div class="guild-contact-card"><div class="contact-icon">📍</div><strong>آدرس</strong><span>{{ $union->address ?: 'گرگان، ساختمان اتاق اصناف' }}</span></div><div class="guild-contact-card"><div class="contact-icon">📞</div><strong>تلفن</strong><span>{{ $union->phone ?: '۰۱۷۳۲۱۵۲۹۱۲' }}</span></div><div class="guild-contact-card"><div class="contact-icon">✉️</div><strong>ایمیل</strong><span>{{ $union->email ?: 'info@asnaf-gorgan.ir' }}</span></div><div class="guild-contact-card"><div class="contact-icon">🕘</div><strong>ساعات کاری</strong><span>{{ $union->working_hours ?: 'شنبه تا چهارشنبه ۸ تا ۱۴' }}</span></div></div>
                <div class="guild-social">@forelse($socialLinks as $link)<a href="{{ $link['url'] }}" target="_blank" rel="noopener" aria-label="{{ $link['label'] }}">{{ mb_substr($link['label'], 0, 1) }}</a>@empty<a href="{{ route('contact.create') }}" aria-label="تماس">☎</a>@endforelse</div>
            </section>
        </div>
    </div>
</main>
@endsection
