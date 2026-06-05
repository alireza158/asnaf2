@extends('frontend.layouts.app')

@section('title', $place->title.' | گردشگری گرگان')
@section('meta_description', Str::limit($place->short_description ?: strip_tags($place->description), 160))
@section('footer_links_variant', 'short')

@section('content')
<section class="page-header page-header-alt">
  <div class="site-container">
    <h1>{{ $place->title }}</h1>
    <nav class="breadcrumb">
      <a href="{{ route('home') }}">خانه</a>
      <a href="{{ route('tourism.index') }}">گردشگری</a>
      <span>{{ $place->title }}</span>
    </nav>
  </div>
</section>

<section class="site-container">
  <div class="news-single-layout">
    <article class="news-single-main">
      <div class="news-single-cover">
        <img src="{{ $place->home_image_url }}" alt="{{ $place->title }}" loading="lazy"/>
      </div>

      <div class="news-single-body">
        <div class="post-meta">
          <span>📅 {{ jalali_date($place->published_at) ?: jalali_date($place->created_at) }}</span>
          <span>🏷 {{ $place->category?->title ?: 'گردشگری' }}</span>
        </div>
        <h2>{{ $place->title }}</h2>
        @if ($place->short_description)
          <p class="lead">{{ $place->short_description }}</p>
        @endif
        <p>{!! nl2br(e($place->description ?: 'توضیحات این مکان گردشگری هنوز تکمیل نشده است.')) !!}</p>
      </div>

      <div class="admin-panel-card mt-4">
        <h3>اطلاعات بازدید</h3>
        <div class="row g-3">
          <div class="col-md-6"><strong>آدرس:</strong><p>{{ $place->address ?: 'ثبت نشده' }}</p></div>
          <div class="col-md-6"><strong>ساعت بازدید:</strong><p>{{ $place->working_hours ?: 'ثبت نشده' }}</p></div>
          <div class="col-md-6"><strong>هزینه بازدید:</strong><p>{{ $place->visit_price ?: 'ثبت نشده' }}</p></div>
          <div class="col-md-6"><strong>تلفن:</strong><p>{{ $place->phone ?: 'ثبت نشده' }}</p></div>
          @if ($place->latitude && $place->longitude)
            <div class="col-md-6"><strong>مختصات:</strong><p dir="ltr">{{ $place->latitude }}, {{ $place->longitude }}</p></div>
          @endif
        </div>
        @if ($place->map_url)
          <div class="mt-3">
            <a class="tab-pill active" href="{{ $place->map_url }}" target="_blank" rel="noopener">مشاهده نقشه</a>
            <div class="mt-3 ratio ratio-16x9">
              <iframe src="{{ $place->map_url }}" title="نقشه {{ $place->title }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade" style="border:0"></iframe>
            </div>
          </div>
        @endif
      </div>

      <div class="admin-panel-card mt-4">
        <h3>گالری تصاویر</h3>
        <div class="tourism-gallery-grid" data-gallery-group="tourism-place-{{ $place->id }}">
          @forelse ($place->gallery_items as $image)
            <div class="tourism-gallery-item" data-gallery-item="{{ $image['url'] }}"><img src="{{ $image['url'] }}" alt="{{ $image['caption'] }}" loading="lazy"/></div>
          @empty
            <div class="tourism-gallery-item" data-gallery-item="{{ $place->home_image_url }}"><img src="{{ $place->home_image_url }}" alt="{{ $place->title }}" loading="lazy"/></div>
          @endforelse
        </div>
      </div>
    </article>

    <aside class="news-sidebar">
      <div class="news-sidebar-card">
        <h4>مکان‌های مرتبط</h4>
        <div class="related-post-list">
          @forelse ($relatedPlaces as $related)
            <a href="{{ route('tourism.show', $related->slug) }}" class="related-post-item">
              <div class="related-post-thumb"><img src="{{ $related->home_image_url }}" alt="{{ $related->title }}" loading="lazy"/></div>
              <div><strong>{{ $related->title }}</strong><span>{{ $related->category?->title ?: 'گردشگری' }}</span></div>
            </a>
          @empty
            <p class="text-muted mb-0">مکان مرتبطی برای نمایش وجود ندارد.</p>
          @endforelse
        </div>
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
