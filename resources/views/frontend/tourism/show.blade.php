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

<section class="tourism-intro">
    <div class="site-container">
        <div class="tourism-intro-grid">
            <div class="tourism-intro-text">
                <h2>{{ $place->title ?? 'مکان گردشگری' }}</h2>


            @if (! empty($place->short_description))
                <p>{{ $place->short_description }}</p>
            @endif

            <p>
                {!! nl2br(e($place->description ?: 'توضیحات این مکان گردشگری هنوز تکمیل نشده است.')) !!}
            </p>

            <div class="tourism-stats">
                <div class="tourism-stat">
                    <strong>📍</strong>
                    <span>{{ $place->address ?: 'آدرس ثبت نشده' }}</span>
                </div>

                <div class="tourism-stat">
                    <strong>⏰</strong>
                    <span>{{ $place->working_hours ?: 'ساعت بازدید ثبت نشده' }}</span>
                </div>

                <div class="tourism-stat">
                    <strong>🏷</strong>
                    <span>{{ $categoryTitle }}</span>
                </div>
            </div>
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

        @if (! empty($mapUrl))
            <div class="tourism-card tourism-card-lg">
                <div class="tourism-card-body">
                    <h3>نقشه</h3>
                    <p>برای مشاهده موقعیت این مکان روی نقشه، از لینک زیر استفاده کنید.</p>
                    <div class="tourism-card-footer">
                        <a href="{{ $mapUrl }}" target="_blank" rel="noopener">مشاهده نقشه</a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if ($isEmbeddableMap)
        <div class="tourism-map-wrap" style="margin-top:32px;border-radius:18px;overflow:hidden">
            <div class="ratio ratio-16x9">
                <iframe
                    src="{{ $mapUrl }}"
                    title="نقشه {{ $place->title }}"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    style="border:0"
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    @endif
</div>


</section>

@if ($galleryItems->isNotEmpty()) <section class="tourism-gallery"> <div class="site-container"> <div class="section-heading section-heading-centered"> <h2>گالری تصاویر</h2> <p>تصاویری از {{ $place->title ?? 'این مکان گردشگری' }}</p> </div>


        <div class="tourism-gallery-grid" data-gallery-group="tourism-place-gallery">
            @foreach ($galleryItems as $image)
                @php($galleryImageUrl = $imageUrl($image['path'] ?? null))

                <div
                    class="tourism-gallery-item"
                    data-gallery-item="{{ $galleryImageUrl }}"
                >
                    <img
                        src="{{ $galleryImageUrl }}"
                        alt="{{ $image['caption'] ?? $place->title ?? 'تصویر گردشگری' }}"
                        loading="lazy"
                    >
                </div>
            @endforeach
        </div>
    </div>
</section>


@endif

<section class="tourism-cta">
    <div class="site-container">
        <div class="tourism-cta-box">
            <h2>گردشگری و اصناف مرتبط</h2>
            <p>
                اتاق اصناف شهرستان گرگان با اتحادیه‌ها و واحدهای صنفی مرتبط با گردشگری، اقامت، رستوران‌ها و خدمات شهری همراه مسافران و شهروندان است.
            </p>
            <a href="{{ route('guilds.index') }}" class="cta-button">مشاهده اتحادیه‌های صنفی</a>
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
