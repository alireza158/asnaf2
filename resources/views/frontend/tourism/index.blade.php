@extends('frontend.layouts.app')

@section('title', 'گردشگری گرگان | اتاق اصناف شهرستان گرگان')
@section('meta_description', 'معرفی مکان‌های گردشگری، مراکز دیدنی، مسیرهای خرید و جاذبه‌های شهر گرگان')
@section('footer_links_variant', 'short')

@section('content')
<section class="page-header page-header-alt page-header-tourism">
  <div class="site-container">
    <h1>گردشگری در گرگان</h1>
    <nav class="breadcrumb">
      <a href="{{ route('home') }}">خانه</a>
      <span>گردشگری گرگان</span>
    </nav>
  </div>
</section>

<section class="tourism-intro">
  <div class="site-container">
    <div class="tourism-intro-grid">
      <div class="tourism-intro-text">
        <h2>به شهر گرگان خوش آمدید</h2>
        <p>گرگان با پیشینه‌ای غنی از تاریخ و فرهنگ، یکی از مقاصد جذاب گردشگری در شمال ایران است. از جنگل‌های انبوه و جاذبه‌های طبیعی تا بازارها و مراکز خدماتی، گرگان پذیرای گردشگران و مسافران عزیز است.</p>
        <p>اتاق اصناف شهرستان گرگان با همراهی اتحادیه‌های صنفی، همواره در خدمت فعالان حوزه گردشگری و مسافران محترم می‌باشد.</p>
        <div class="tourism-stats">
          <div class="tourism-stat"><strong>{{ number_format($places->total()) }}+</strong><span>جاذبه گردشگری</span></div>
          <div class="tourism-stat"><strong>{{ number_format($categories->count()) }}+</strong><span>دسته‌بندی</span></div>
          <div class="tourism-stat"><strong>۱۲۰۰+</strong><span>صنف مرتبط</span></div>
        </div>
      </div>
      <div class="tourism-intro-img">
        <img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="گرگان" loading="lazy"/>
      </div>
    </div>
  </div>
</section>

<section class="tourism-attractions">
  <div class="site-container">
    <div class="section-heading section-heading-centered">
      <h2>جاذبه‌های گردشگری</h2>
      <p>جاذبه‌های طبیعی، تاریخی، خرید و اقامت گرگان را براساس دسته‌بندی مرور کنید.</p>
    </div>

    <form class="archive-filters mb-4" action="{{ route('tourism.index') }}" method="GET">
      @if ($activeCategory !== '')
        <input type="hidden" name="category" value="{{ $activeCategory }}">
      @endif
      <input class="form-control" name="search" value="{{ $search }}" placeholder="جستجو براساس نام، توضیحات یا آدرس..." type="search">
      <button class="tab-pill active" type="submit">جستجو</button>
      @if ($search !== '' || $activeCategory !== '')
        <a class="tab-pill" href="{{ route('tourism.index') }}">نمایش همه</a>
      @endif
    </form>

    <div class="tabs tourism-tabs" aria-label="فیلتر دسته‌بندی گردشگری">
      <a class="tab-pill {{ $activeCategory === '' ? 'active' : '' }}" href="{{ route('tourism.index', array_filter(['search' => $search])) }}">همه مکان‌ها</a>
      @foreach ($categories as $category)
        <a class="tab-pill {{ $activeCategory === $category->slug || $activeCategory === (string) $category->id ? 'active' : '' }}" href="{{ route('tourism.index', array_filter(['category' => $category->slug, 'search' => $search])) }}">
          {{ $category->title }}
        </a>
      @endforeach
    </div>

    <div class="tab-panels">
      <div class="tab-panel active">
        <div class="tourism-grid tourism-grid-lg">
          @forelse ($places as $place)
            <div class="tourism-card tourism-card-lg">
              <a href="{{ route('tourism.show', $place->slug) }}">
                <div class="tourism-img-wrap">
                  <img src="{{ $place->featured_image ? Storage::url($place->featured_image) : asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="{{ $place->title }}" loading="lazy"/>
                  <div class="tourism-badge">{{ $place->category?->title ?: 'گردشگری' }}</div>
                </div>
              </a>
              <div class="tourism-card-body">
                <h3><a href="{{ route('tourism.show', $place->slug) }}">{{ $place->title }}</a></h3>
                <p>{{ Str::limit($place->short_description ?: strip_tags($place->description), 140) ?: 'اطلاعات این مکان گردشگری به‌زودی تکمیل می‌شود.' }}</p>
                <div class="tourism-card-footer">
                  <span>📍 {{ Str::limit($place->address ?: 'گرگان', 35) }}</span>
                  @if ($place->working_hours)<span>🕘 {{ $place->working_hours }}</span>@endif
                </div>
              </div>
            </div>
          @empty
            <p class="text-muted text-center">مکان گردشگری منتشرشده‌ای با این شرایط یافت نشد.</p>
          @endforelse
        </div>
      </div>
    </div>

    {{ $places->links('frontend.partials.pagination') }}
  </div>
</section>
@endsection
