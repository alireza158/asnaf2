@extends('frontend.layouts.app')

@section('title', $place->title.' | گردشگری گرگان')
@section('meta_description', Str::limit($place->short_description ?: strip_tags($place->description), 160))
@section('frontend_variant', 'compact')
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
        <img src="{{ $place->featured_image ? Storage::url($place->featured_image) : asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="{{ $place->title }}" loading="lazy"/>
      </div>

      <div class="news-single-body">
        <div class="post-meta">
          <span>📅 {{ $place->published_at?->format('Y/m/d') ?: $place->created_at?->format('Y/m/d') }}</span>
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

      @if (! empty($place->gallery))
        <div class="admin-panel-card mt-4">
          <h3>گالری تصاویر</h3>
          <div class="tourism-grid" data-gallery-group>
            @foreach (collect($place->gallery)->sortBy('sort_order') as $image)
              @php($imageUrl = Storage::url($image['path'] ?? ''))
              <a class="tourism-card" href="{{ $imageUrl }}" data-gallery-item data-caption="{{ $image['caption'] ?? $place->title }}">
                <div class="tourism-img-wrap"><img src="{{ $imageUrl }}" alt="{{ $image['caption'] ?? $place->title }}" loading="lazy"></div>
                @if (! empty($image['caption']))<div class="tourism-card-body"><p>{{ $image['caption'] }}</p></div>@endif
              </a>
            @endforeach
          </div>
        </div>
      @endif
    </article>

    <aside class="news-sidebar">
      <div class="news-sidebar-card">
        <h4>مکان‌های مرتبط</h4>
        <div class="related-post-list">
          @forelse ($relatedPlaces as $related)
            <a href="{{ route('tourism.show', $related->slug) }}" class="related-post-item">
              <div class="related-post-thumb"><img src="{{ $related->featured_image ? Storage::url($related->featured_image) : asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="{{ $related->title }}" loading="lazy"/></div>
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
