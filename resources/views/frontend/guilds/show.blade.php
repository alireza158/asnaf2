@extends('frontend.layouts.app')

@section('title', ($union->meta_title ?: $union->display_title).' | اتاق اصناف شهرستان گرگان')
@section('meta_description', $union->meta_description ?: $union->short_description)
@section('meta_keywords', $union->meta_keywords)

@section('content')
<div class="guild-hero">
    <img alt="{{ $union->display_title }}" class="guild-hero-bg" src="{{ $union->cover_image ? Storage::url($union->cover_image) : asset('assets/img/asnaf-gorgan-default.jpg') }}">
    <div class="site-container guild-hero-content">
        <div class="guild-hero-logo">
            @if ($union->logo)
                <img src="{{ Storage::url($union->logo) }}" alt="{{ $union->display_title }}" style="width:100%;height:100%;object-fit:contain">
            @else
                {{ mb_substr($union->display_title, 0, 1) }}
            @endif
        </div>
        <div class="guild-hero-text">
            <nav class="breadcrumb-nav" style="margin-bottom:10px">
                <a href="{{ route('home') }}" style="color:rgba(255,255,255,.6)">خانه</a>
                <span class="breadcrumb-sep">/</span>
                <a href="{{ route('guilds.index') }}" style="color:rgba(255,255,255,.6)">اتحادیه‌ها</a>
                <span class="breadcrumb-sep">/</span>
                <span style="color:rgba(255,255,255,.8)">{{ $union->display_title }}</span>
            </nav>
            <h1>{{ $union->display_title }}</h1>
            <p>{{ $union->short_description }}</p>
            <div class="guild-hero-stats">
                <span>مدیر: <strong>{{ $union->manager_name ?: 'در حال تکمیل' }}</strong></span>
                <span>تلفن: <strong>{{ $union->phone ?: 'ثبت نشده' }}</strong></span>
                <span>آخرین بروزرسانی: <strong>{{ jalali_date($union->updated_at) ?: '—' }}</strong></span>
            </div>
        </div>
    </div>
</div>

<main>
    <div class="site-container guild-layout">
        <aside class="guild-side-nav">
            <h4>راهنمای سریع</h4>
            <ul>
                <li><a href="#guild-manager">رییس اتحادیه</a></li>
                <li><a href="#guild-members">اعضای هیئت مدیره</a></li>
                <li><a href="#guild-rules">قوانین و خدمات</a></li>
                <li><a href="#guild-contact">تماس با اتحادیه</a></li>
                @if ($union->news_enabled)<li><a href="#guild-news">آخرین اخبار</a></li>@endif
                @if ($union->announcements_enabled)<li><a href="#guild-announce">اطلاعیه‌ها</a></li>@endif
                @if ($union->gallery_enabled)<li><a href="#guild-gallery">گالری تصاویر</a></li>@endif
                @if ($union->videos_enabled)<li><a href="#guild-videos">ویدیوها</a></li>@endif
                @if ($union->members_enabled)<li><a href="#guild-members">اعضا</a></li>@endif
                @if ($union->services_enabled)<li><a href="#guild-services">خدمات</a></li>@endif
                @if ($union->complaint_enabled)<li><a href="#guild-complaint">ثبت شکایت صنفی</a></li>@endif
                @if ($union->congratulations_enabled)<li><a href="#guild-congratulations">پیام مدیر</a></li>@endif
            </ul>
        </aside>

        <div>
            <section class="guild-section guild-section-alt" id="guild-manager" style="padding-top:0">
                <h3 class="guild-section-title">رییس اتحادیه {{ $union->display_title }}</h3>
                <div class="guild-head-card">
                    <div class="guild-head-avatar">
                        @if ($union->manager_image)
                            <img src="{{ Storage::url($union->manager_image) }}" alt="{{ $union->manager_name }}" style="width:100%;height:100%;object-fit:cover;border-radius:inherit">
                        @else
                            {{ mb_substr($union->manager_name ?: $union->display_title, 0, 1) }}
                        @endif
                    </div>
                    <div class="guild-head-info">
                        <strong>{{ $union->manager_name ?: 'مدیر اتحادیه' }}</strong>
                        <span>{{ $union->display_title }}</span>
                        <p>{{ $union->description ?: $union->short_description ?: 'اطلاعات معرفی این اتحادیه به‌زودی تکمیل می‌شود.' }}</p>
                        <div class="guild-head-contact">
                            @if ($union->phone)<a href="tel:{{ $union->phone }}">تماس با رییس اتحادیه</a>@endif
                            <a href="#guild-contact">اطلاعات تماس</a>
                        </div>
                    </div>
                </div>
            </section>

            @if ($union->news_enabled)
                <section class="guild-section" id="guild-news">
                    <h3 class="guild-section-title">آخرین اخبار اتحادیه</h3>
                    <div class="guild-article-list">
                        @forelse ($posts as $post)
                            <a class="guild-article-item" href="{{ route('posts.show', $post->slug) }}"><img src="{{ $post->featured_image ? Storage::url($post->featured_image) : asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="{{ $post->title }}"><div><h4>{{ $post->title }}</h4><p>{{ $post->excerpt ?: Str::limit(strip_tags($post->body), 120) }}</p><span class="item-date">{{ jalali_date($post->published_at) }}</span></div></a>
                        @empty
                            <p class="text-muted">هنوز خبری برای این اتحادیه منتشر نشده است.</p>
                        @endforelse
                    </div>
                </section>
            @endif

            @if ($union->announcements_enabled)
                <section class="guild-section guild-section-alt" id="guild-announce">
                    <h3 class="guild-section-title">اطلاعیه‌ها و بخشنامه‌ها</h3>
                    <div class="archive-grid">
                        @forelse ($announcements as $announcement)
                            <article class="archive-card"><a href="{{ route('announcements.show', $announcement->slug) }}"><img class="archive-card-img" src="{{ $announcement->featured_image ? Storage::url($announcement->featured_image) : asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="{{ $announcement->title }}"><div class="archive-card-body"><span class="card-cat">اطلاعیه</span><h2>{{ $announcement->title }}</h2><p>{{ $announcement->excerpt }}</p></div></a></article>
                        @empty
                            <p class="text-muted">هنوز اطلاعیه‌ای برای این اتحادیه منتشر نشده است.</p>
                        @endforelse
                    </div>
                </section>
            @endif

            @if ($union->members_enabled)
                <section class="guild-section guild-section-alt" id="guild-members">
                    <h3 class="guild-section-title">اعضای هیئت مدیره اتحادیه</h3>
                    <div class="guild-members-grid">
                        @foreach (['نایب رییس', 'دبیر اتحادیه', 'عضو هیئت مدیره', 'بازرس'] as $role)
                            <div class="guild-member-card">
                                <div class="member-avatar">{{ mb_substr($role, 0, 1) }}</div>
                                <strong>{{ $union->manager_name ?: 'در حال تکمیل' }}</strong>
                                <small>{{ $role }}</small>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
            <section class="guild-section guild-section-alt" id="guild-rules">
                <h3 class="guild-section-title">قوانین، دستورالعمل‌ها و خدمات</h3>
                <div class="guild-2col">
                    <div class="guild-rules-list">
                        <div class="guild-rule-item"><div class="rule-icon">📋</div><div><strong>دستورالعمل‌های صنفی</strong><small>بخشنامه‌ها و مقررات مرتبط با {{ $union->display_title }}</small></div></div>
                        <div class="guild-rule-item"><div class="rule-icon">🧾</div><div><strong>نرخ‌نامه و اطلاع‌رسانی</strong><small>اطلاع‌رسانی نرخ‌ها و خدمات مصوب اتحادیه</small></div></div>
                        <div class="guild-rule-item"><div class="rule-icon">🎓</div><div><strong>آموزش اعضا</strong><small>راهنمای آموزشی و دوره‌های تخصصی صنف</small></div></div>
                    </div>
                    <div class="guild-rules-list">
                        <div class="guild-rule-item"><div class="rule-icon">✅</div><div><strong>صدور و تمدید پروانه</strong><small>راهنمای خدمات پروانه کسب برای اعضای اتحادیه</small></div></div>
                        <div class="guild-rule-item"><div class="rule-icon">🤝</div><div><strong>حل اختلاف و رسیدگی</strong><small>پیگیری درخواست‌ها، شکایات و امور صنفی</small></div></div>
                        <div class="guild-rule-item"><div class="rule-icon">☎️</div><div><strong>پاسخگویی به اعضا</strong><small>{{ $union->working_hours ?: 'ساعات پاسخگویی از طریق اتحادیه اعلام می‌شود.' }}</small></div></div>
                    </div>
                </div>
            </section>
            @if ($union->services_enabled)
                <section class="guild-section guild-section-alt" id="guild-services"><h3 class="guild-section-title">خدمات</h3><div class="guild-commission-list"><div class="guild-commission-item"><div class="com-num">۱</div><div><strong>خدمات قابل ارائه اتحادیه</strong><small>خدمات این اتحادیه از همین بخش اطلاع‌رسانی می‌شود.</small></div></div></div></section>
            @endif
            @if ($union->gallery_enabled)
                <section class="guild-section" id="guild-gallery"><h3 class="guild-section-title">گالری تصاویر</h3><p>گالری تصاویر این اتحادیه فعال است.</p></section>
            @endif
            @if ($union->videos_enabled)
                <section class="guild-section guild-section-alt" id="guild-videos"><h3 class="guild-section-title">ویدیوها</h3><p>ویدیوهای این اتحادیه از این بخش نمایش داده می‌شوند.</p></section>
            @endif
            @if ($union->complaint_enabled)
                <section class="guild-section" id="guild-complaint"><h3 class="guild-section-title">ثبت شکایت صنفی</h3><p>فرم شکایت برای این اتحادیه فعال است.</p><a class="tab-pill active" href="{{ route('complaints.create', ['union_id' => $union->id]) }}">ثبت شکایت از این اتحادیه</a></section>
            @endif
            @if ($union->congratulations_enabled)
                <section class="guild-section guild-section-alt" id="guild-congratulations"><h3 class="guild-section-title">پیام تبریک مدیر</h3><div class="howto-grid">@forelse($congratulationMessages as $message)<a class="howto-card" href="{{ route('congratulation_messages.show', $message->slug) }}"><div class="howto-icon">🎉</div><h3>{{ $message->title }}</h3><p>{{ Str::limit(strip_tags($message->body), 120) }}</p><span class="howto-link">مشاهده پیام ←</span></a>@empty<p>پیام تبریکی برای این اتحادیه منتشر نشده است.</p>@endforelse</div></section>
            @endif

            <section class="guild-section" id="guild-contact">
                <h3 class="guild-section-title">تماس با اتحادیه</h3>
                <div class="guild-contact-grid">
                    <div class="guild-contact-card"><strong>آدرس</strong><p>{{ $union->address ?: 'آدرس اتحادیه ثبت نشده است.' }}</p></div>
                    <div class="guild-contact-card"><strong>تلفن</strong><p>{{ $union->phone ?: 'ثبت نشده' }}</p></div>
                    <div class="guild-contact-card"><strong>موبایل</strong><p>{{ $union->mobile ?: 'ثبت نشده' }}</p></div>
                    <div class="guild-contact-card"><strong>ایمیل</strong><p>{{ $union->email ?: 'ثبت نشده' }}</p></div>
                    @if ($union->website)<div><strong>وب‌سایت</strong><p><a href="{{ $union->website }}" target="_blank">{{ $union->website }}</a></p></div>@endif
                </div>
                @if ($union->social_links)
                    <div class="post-tags">
                        @foreach ($union->social_links as $network => $url)
                            <a class="post-tag" href="{{ $url }}" target="_blank">{{ $network }}</a>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>
    </div>
</main>
@endsection
