@extends('frontend.layouts.app')

@section('title', 'آرشیو ویدیوها | اتاق اصناف شهرستان گرگان')
@section('meta_description', 'آرشیو ویدیوهای آموزشی، خبری و گزارش‌های تصویری اتاق اصناف شهرستان گرگان')
@section('footer_links_variant', 'short')

@section('content')
<section class="page-header page-header-alt">
  <div class="site-container">
    <h1>آرشیو ویدیوها</h1>
    <nav class="breadcrumb">
      <a href="{{ route('home') }}">خانه</a>
      <span>ویدیوها</span>
    </nav>
  </div>
</section>

<section class="site-container">
  <div class="section-heading section-heading-centered">
    <h2>ویدیوهای منتشرشده</h2>
    <p>گزارش‌های تصویری، آموزش‌ها و محتوای چندرسانه‌ای اتاق اصناف</p>
  </div>

  <form class="archive-filters mb-4" action="{{ route('videos.index') }}" method="GET">
    <input class="form-control" name="search" value="{{ $search }}" placeholder="جستجو در ویدیوها..." type="search">
    <button class="tab-pill active" type="submit">جستجو</button>
    @if ($search !== '')<a class="tab-pill" href="{{ route('videos.index') }}">حذف جستجو</a>@endif
  </form>

  <div class="tourism-grid">
    @forelse ($videos as $video)
      <div class="tourism-card">
        <a href="{{ route('videos.show', $video->slug) }}">
          <div class="tourism-img-wrap">
            <img alt="{{ $video->title }}" src="{{ $video->cover_image ? Storage::url($video->cover_image) : asset('assets/img/asnaf-gorgan-default.jpg') }}" loading="lazy"/>
            <div class="tourism-badge">{{ $video->type_label }}</div>
          </div>
          <div class="tourism-card-body">
            <h3>{{ $video->title }}</h3>
            <p>{{ Str::limit(strip_tags($video->description), 110) ?: 'ویدیوی منتشرشده اتاق اصناف شهرستان گرگان' }}</p>
          </div>
        </a>
      </div>
    @empty
      <p class="text-muted text-center">ویدیوی منتشرشده‌ای یافت نشد.</p>
    @endforelse
  </div>

  {{ $videos->links('frontend.partials.pagination') }}
</section>
@endsection
