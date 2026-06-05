@extends('frontend.layouts.app')

@section('title', 'خدمات الکترونیک | اتاق اصناف مرکز استان گلستان')
@section('meta_description', 'لیست خدمات الکترونیک صنفی اتاق اصناف مرکز استان گلستان')
@section('frontend_variant', 'compact')
@section('footer_links_variant', 'short')

@section('content')
<section class="page-header page-header-alt"><div class="site-container"><h1>خدمات الکترونیک</h1><nav class="breadcrumb"><a href="{{ route('home') }}">خانه</a><span>خدمات الکترونیک</span></nav></div></section>

<section class="site-container">
  <div class="section-heading section-heading-centered"><h2>خدمات الکترونیک صنفی</h2><p>دسترسی به خدمات، راهنماها و فرآیندهای آنلاین مرتبط با اصناف</p></div>

  <form class="archive-filters mb-4" action="{{ route('electronic-services.index') }}" method="GET">
    @if ($activeCategory !== '')<input type="hidden" name="category" value="{{ $activeCategory }}">@endif
    <input class="form-control" name="search" value="{{ $search }}" placeholder="جستجو در خدمات..." type="search">
    <button class="tab-pill active" type="submit">جستجو</button>
    @if ($search !== '' || $activeCategory !== '')<a class="tab-pill" href="{{ route('electronic-services.index') }}">نمایش همه</a>@endif
  </form>

  <div class="tourism-tabs" aria-label="فیلتر دسته‌بندی خدمات">
    <a class="tab-pill {{ $activeCategory === '' ? 'active' : '' }}" href="{{ route('electronic-services.index', array_filter(['search' => $search])) }}">همه خدمات</a>
    @foreach ($categories as $category)
      <a class="tab-pill {{ $activeCategory === $category->slug || $activeCategory === (string) $category->id ? 'active' : '' }}" href="{{ route('electronic-services.index', array_filter(['category' => $category->slug, 'search' => $search])) }}">{{ $category->title }}</a>
    @endforeach
  </div>

  <div class="howto-grid mt-4">
    @forelse ($services as $service)
      <a class="howto-card" href="{{ route('electronic-services.show', $service->slug) }}">
        <div class="howto-icon">{{ $service->icon ?: '⚡' }}</div>
        <h3>{{ $service->title }}</h3>
        <p>{{ Str::limit($service->short_description ?: strip_tags($service->body), 120) ?: 'توضیحات این خدمت به‌زودی تکمیل می‌شود.' }}</p>
        <span class="howto-link">مشاهده جزئیات ←</span>
      </a>
    @empty
      <p class="text-muted text-center">خدمت الکترونیکی فعالی برای نمایش یافت نشد.</p>
    @endforelse
  </div>

  <div class="mt-4">{{ $services->links() }}</div>
</section>
@endsection
