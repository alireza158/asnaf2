@extends('frontend.layouts.app')

@section('title', ($place->title ?? 'مکان گردشگری') . ' | گردشگری گرگان')
@section('meta_description', \Illuminate\Support\Str::limit($place->short_description ?: strip_tags($place->description ?? ''), 160))
@section('footer_links_variant', 'short')

@section('content')
@php
    $imageUrl = function ($path) {
        if (!$path) return asset('assets/img/asnaf-gorgan-default.jpg');
        if (filter_var($path, FILTER_VALIDATE_URL)) return $path;
        if (str_starts_with($path, 'assets/')) return asset($path);
        if (str_starts_with($path, 'storage/')) return asset($path);
        return \Illuminate\Support\Facades\Storage::url($path);
    };

    $featuredImage = $imageUrl($place->featured_image ?? null);
    $galleryItems = collect($place->gallery_items ?? [])
        ->filter(fn($item) => isset($item['path']) && $item['path'])
        ->sortBy('sort_order');
    $categoryTitle = $place->category?->title ?: 'گردشگری';
    $mapUrl = $place->map_url ?? null;
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

<section class="tourism-intro site-container">
    <div class="tourism-intro-grid">
        <div class="tourism-intro-text">
            <h2>{{ $place->title ?? 'مکان گردشگری' }}</h2>
            @if ($place->short_description)
                <p>{{ $place->short_description }}</p>
            @endif
            <p>{!! nl2br(e($place->description ?: 'توضیحات این مکان گردشگری هنوز تکمیل نشده است.')) !!}</p>
        </div>
        <div class="tourism-intro-img">
            <img src="{{ $featuredImage }}" alt="{{ $place->title ?? 'مکان گردشگری' }}" loading="lazy">
        </div>
    </div>
</section>

<section class="tourism-attractions site-container">
    <div class="section-heading section-heading-centered">
        <h2>اطلاعات بازدید</h2>
        <p>جزئیات دسترسی، ساعت بازدید و راه‌های ارتباطی این مکان گردشگری</p>
    </div>
    <div class="tourism-grid tourism-grid-lg">
        <div class="tourism-card tourism-card-lg"><h3>آدرس</h3><p>{{ $place->address ?: 'ثبت نشده' }}</p></div>
        <div class="tourism-card tourism-card-lg"><h3>ساعت بازدید</h3><p>{{ $place->working_hours ?: 'ثبت نشده' }}</p></div>
        <div class="tourism-card tourism-card-lg"><h3>هزینه بازدید</h3><p>{{ $place->visit_price ?: 'ثبت نشده' }}</p></div>
        <div class="tourism-card tourism-card-lg"><h3>تلفن تماس</h3><p>{{ $place->phone ?: 'ثبت نشده' }}</p></div>
        @if ($place->latitude && $place->longitude)
            <div class="tourism-card tourism-card-lg"><h3>مختصات</h3><p dir="ltr">{{ $place->latitude }}, {{ $place->longitude }}</p></div>
        @endif
        @if ($mapUrl)
            <div class="tourism-card tourism-card-lg">
                <h3>نقشه</h3>
                <a href="{{ $mapUrl }}" target="_blank" rel="noopener">مشاهده نقشه</a>
            </div>
        @endif
    </div>
</section>

@if ($galleryItems->isNotEmpty())
<section class="tourism-gallery site-container">
    <div class="section-heading section-heading-centered">
        <h2>گالری تصاویر</h2>
        <p>تصاویر مکان گردشگری {{ $place->title ?? '' }}</p>
    </div>
    <div class="tourism-gallery-grid" data-gallery-group="tourism-place-{{ $place->id }}">
        @foreach ($galleryItems as $image)
            @php
                $galleryImageUrl = $imageUrl($image['path'] ?? null);
            @endphp
            <div class="tourism-gallery-item" data-gallery-item="{{ $galleryImageUrl }}">
                <img src="{{ $galleryImageUrl }}" alt="{{ $image['caption'] ?? $place->title }}" loading="lazy"/>
            </div>
        @endforeach
    </div>
</section>
@endif

@if (!empty($relatedPlaces) && $relatedPlaces->count())
<section class="tourism-related site-container">
    <div class="section-heading section-heading-centered">
        <h2>مکان‌های مرتبط</h2>
        <p>جاذبه‌های مشابه و نزدیک برای بازدید بیشتر</p>
    </div>
    <div class="tourism-grid tourism-grid-lg">
        @foreach ($relatedPlaces as $related)
            <div class="tourism-card tourism-card-lg">
                <a href="{{ route('tourism.show', $related->slug) }}">
                    <div class="tourism-img-wrap">
                        <img src="{{ $imageUrl($related->featured_image ?? null) }}" alt="{{ $related->title }}" loading="lazy">
                        <div class="tourism-badge">{{ $related->category?->title ?: 'گردشگری' }}</div>
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