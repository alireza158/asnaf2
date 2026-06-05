@extends('frontend.layouts.app')

@section('title', 'گالری تصاویر | اتاق اصناف شهرستان گرگان')
@section('meta_description', 'فهرست گالری تصاویر رویدادها، جلسات و فعالیت‌های اتاق اصناف شهرستان گرگان')
@section('footer_links_variant', 'full')

@section('content')
<section class="page-header page-header-alt">
  <div class="site-container">
    <h1>گالری تصاویر</h1>
    <nav class="breadcrumb">
      <a href="{{ route('home') }}">خانه</a>
      <span>گالری</span>
    </nav>
  </div>
</section>

<section class="site-container">
  <div class="section-heading section-heading-centered">
    <h2>آلبوم‌های تصویری</h2>
    <p>مجموعه تصاویر رویدادها، جلسات و فعالیت‌های اتاق اصناف</p>
  </div>

  <form class="archive-filters mb-4" action="{{ route('galleries.index') }}" method="GET">
    <input class="form-control" name="search" value="{{ $search }}" placeholder="جستجو در گالری‌ها..." type="search">
    <button class="tab-pill active" type="submit">جستجو</button>
    @if ($search !== '')<a class="tab-pill" href="{{ route('galleries.index') }}">حذف جستجو</a>@endif
  </form>

  <div class="gallery-albums-grid">
    @forelse ($galleries as $gallery)
      <a href="{{ route('galleries.show', $gallery->slug) }}" class="gallery-album-card">
        <div class="gallery-album-img"><img src="{{ $gallery->cover_image ? Storage::url($gallery->cover_image) : asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="{{ $gallery->title }}" loading="lazy"/></div>
        <div class="gallery-album-body">
          <h3>{{ $gallery->title }}</h3>
          <p>{{ Str::limit(strip_tags($gallery->description), 130) ?: 'گالری تصاویر اتاق اصناف شهرستان گرگان' }}</p>
          <div class="gallery-album-meta">
            <span>{{ $gallery->images_count }} تصویر</span>
            <span>{{ jalali_date($gallery->published_at) ?: jalali_date($gallery->created_at) }}</span>
          </div>
        </div>
      </a>
    @empty
      <p class="text-muted text-center">گالری تصویری منتشرشده‌ای یافت نشد.</p>
    @endforelse
  </div>

  {{ $galleries->links('frontend.partials.pagination') }}
</section>
@endsection
