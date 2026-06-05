@extends('frontend.layouts.app')

@section('title', ($place->title ?? 'مکان گردشگری') . ' | گردشگری گرگان')
@section('meta_description', \Illuminate\Support\Str::limit($place->short_description ?: strip_tags($place->description ?? ''), 160))
@section('footer_links_variant', 'short')

@section('content')
@php
$imageUrl = function ($path) {
if (! $path) {
return asset('assets/img/asnaf-gorgan-default.jpg');
}


    if (filter_var($path, FILTER_VALIDATE_URL)) {
        return $path;
    }

    if (str_starts_with($path, 'assets/')) {
        return asset($path);
    }

    if (str_starts_with($path, 'storage/')) {
        return asset($path);
    }

    return \Illuminate\Support\Facades\Storage::url($path);
};

$featuredImage = $imageUrl($place->featured_image ?? null);

$galleryItems = collect($place->gallery ?? [])
    ->filter(fn ($item) => ! empty($item['path'] ?? null))
    ->sortBy('sort_order');

$categoryTitle = $place->category?->title ?: 'گردشگری';

$mapUrl = $place->map_url ?? null;
$isEmbeddableMap = $mapUrl && str_contains($mapUrl, 'embed');


@endphp

<section class="page-header page-header-alt page-header-tourism">
    <div class="site-container">
        <h1>{{ $place->title ?? 'مکان گردشگری' }}</h1>


    <nav class="breadcrumb">
        <a href="{{ route('home') }}">خانه</a>
        <a href="{{ route('tourism.index') }}">گردشگری</a>
        <span>{{ $place->title ?? 'مکان گردشگری' }}</span>
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

        <div class="tourism-intro-img">
            <img src="{{ $featuredImage }}" alt="{{ $place->title ?? 'مکان گردشگری' }}" loading="lazy">
        </div>
    </div>
</div>


</section>

<section class="tourism-attractions">
    <div class="site-container">
        <div class="section-heading section-heading-centered">
            <h2>اطلاعات بازدید</h2>
            <p>جزئیات دسترسی، ساعت بازدید و راه‌های ارتباطی این مکان گردشگری</p>
        </div>


    <div class="tourism-grid tourism-grid-lg">
        <div class="tourism-card tourism-card-lg">
            <div class="tourism-card-body">
                <h3>آدرس</h3>
                <p>{{ $place->address ?: 'آدرس این مکان هنوز ثبت نشده است.' }}</p>
                <div class="tourism-card-footer">
                    <span>📍 موقعیت مکانی</span>
                </div>
            </div>
        </div>

        <div class="tourism-card tourism-card-lg">
            <div class="tourism-card-body">
                <h3>ساعت بازدید</h3>
                <p>{{ $place->working_hours ?: 'ساعت بازدید هنوز ثبت نشده است.' }}</p>
                <div class="tourism-card-footer">
                    <span>⏰ زمان مراجعه</span>
                </div>
            </div>
        </div>

        <div class="tourism-card tourism-card-lg">
            <div class="tourism-card-body">
                <h3>هزینه بازدید</h3>
                <p>{{ $place->visit_price ?: 'هزینه بازدید هنوز ثبت نشده است.' }}</p>
                <div class="tourism-card-footer">
                    <span>💳 هزینه ورود</span>
                </div>
            </div>
        </div>

        <div class="tourism-card tourism-card-lg">
            <div class="tourism-card-body">
                <h3>تلفن تماس</h3>
                <p>{{ $place->phone ?: 'شماره تماس ثبت نشده است.' }}</p>
                <div class="tourism-card-footer">
                    @if (! empty($place->phone))
                        <span>☎ {{ $place->phone }}</span>
                    @else
                        <span>☎ اطلاعات تماس</span>
                    @endif
                </div>
            </div>
        </div>

        @if (! empty($place->latitude) && ! empty($place->longitude))
            <div class="tourism-card tourism-card-lg">
                <div class="tourism-card-body">
                    <h3>مختصات جغرافیایی</h3>
                    <p dir="ltr">{{ $place->latitude }}, {{ $place->longitude }}</p>
                    <div class="tourism-card-footer">
                        <span>🗺 مختصات</span>
                    </div>
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
</section>

@if (! empty($relatedPlaces) && $relatedPlaces->count()) <section class="tourism-attractions"> <div class="site-container"> <div class="section-heading section-heading-centered"> <h2>مکان‌های مرتبط</h2> <p>جاذبه‌های مشابه و نزدیک برای بازدید بیشتر</p> </div>

```
        <div class="tourism-grid tourism-grid-lg">
            @foreach ($relatedPlaces as $related)
                <div class="tourism-card tourism-card-lg">
                    <a href="{{ route('tourism.show', $related->slug) }}">
                        <div class="tourism-img-wrap">
                            <img
                                src="{{ $imageUrl($related->featured_image ?? null) }}"
                                alt="{{ $related->title }}"
                                loading="lazy"
                            >
                            <div class="tourism-badge">
                                {{ $related->category?->title ?: 'گردشگری' }}
                            </div>
                        </div>
                    </a>

                    <div class="tourism-card-body">
                        <h3>{{ $related->title }}</h3>
                        <p>{{ $related->short_description ?: \Illuminate\Support\Str::limit(strip_tags($related->description), 120) }}</p>

                        <div class="tourism-card-footer">
                            <span>📍 {{ $related->address ?: 'گرگان' }}</span>
                            <span>🏷 {{ $related->category?->title ?: 'گردشگری' }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>


@endif
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
