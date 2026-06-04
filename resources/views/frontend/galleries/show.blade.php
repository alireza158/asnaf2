@extends('frontend.layouts.app')

@section('title', $gallery->title.' | اتاق اصناف شهرستان گرگان')
@section('meta_description', Str::limit(strip_tags($gallery->description), 160))
@section('frontend_variant', 'compact')
@section('compact_show_tourism_nav', 'false')
@section('footer_links_variant', 'gallery-detail')

@section('content')
<section class="page-header page-header-alt">
  <div class="site-container">
    <h1>{{ $gallery->title }}</h1>
    <nav class="breadcrumb">
      <a href="{{ route('home') }}">خانه</a>
      <a href="{{ route('galleries.index') }}">گالری</a>
      <span>{{ $gallery->title }}</span>
    </nav>
  </div>
</section>

<section class="site-container">
  <div class="gallery-single-layout">
    <div class="gallery-single-main">
      <p class="gallery-desc">{{ $gallery->description ?: 'تصاویر منتخب این گالری را می‌توانید مشاهده کنید.' }}</p>

      <div class="gallery-thumbs" data-gallery-group="gallery-{{ $gallery->id }}">
        @forelse ($gallery->images as $image)
          <div class="gallery-thumb" data-gallery-item="{{ Storage::url($image->image) }}">
            <img src="{{ Storage::url($image->image) }}" alt="{{ $image->caption ?: $gallery->title }}" loading="lazy"/>
          </div>
        @empty
          <div class="gallery-thumb" data-gallery-item="{{ $gallery->cover_image ? Storage::url($gallery->cover_image) : asset('assets/img/asnaf-gorgan-default.jpg') }}">
            <img src="{{ $gallery->cover_image ? Storage::url($gallery->cover_image) : asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="{{ $gallery->title }}" loading="lazy"/>
          </div>
        @endforelse
      </div>
    </div>

    <aside class="gallery-sidebar">
      <div class="gallery-sidebar-card">
        <h4>سایر گالری‌ها</h4>
        <ul class="gallery-sidebar-list">
          @forelse ($relatedGalleries as $related)
            <li><a href="{{ route('galleries.show', $related->slug) }}">{{ $related->title }}</a></li>
          @empty
            <li>گالری دیگری برای نمایش وجود ندارد.</li>
          @endforelse
        </ul>
      </div>
      <div class="gallery-sidebar-card">
        <h4>آمار گالری</h4>
        <ul class="gallery-sidebar-list">
          <li>تعداد تصاویر: {{ $gallery->images->count() }}</li>
          <li>نوع گالری: {{ $gallery->union?->display_title ?: 'عمومی' }}</li>
          <li>تاریخ انتشار: {{ $gallery->published_at?->format('Y/m/d') ?: '—' }}</li>
          <li>آخرین بروزرسانی: {{ $gallery->updated_at?->format('Y/m/d') ?: '—' }}</li>
        </ul>
      </div>
    </aside>
  </div>
</section>
@endsection

@section('after_footer')
<div class="lightbox">
  <button class="lightbox-close" aria-label="بستن">✕</button>
  <button class="lightbox-nav lightbox-prev" aria-label="قبلی">‹</button>
  <button class="lightbox-nav lightbox-next" aria-label="بعدی">›</button>
  <img class="lightbox-img" src="" alt="تصویر بزرگ"/>
  <div class="lightbox-counter"></div>
</div>
@endsection
