@php
    $imageUrl = fn ($path) => $path ? (Str::startsWith($path, ['http://', 'https://', '/', 'assets/']) ? (Str::startsWith($path, 'assets/') ? asset($path) : $path) : Storage::url($path)) : asset('assets/img/asnaf-gorgan-default.jpg');
@endphp
<section class="representatives-section section-white" id="galleries">
    <div class="site-container">
        <div class="section-heading"><h2>{{ $section->title }}</h2><a class="tab-pill" href="{{ route('galleries.index') }}">گالری تصاویر</a></div>
        <div class="gallery-albums-grid">
            @forelse ($latestGalleries ?? collect() as $gallery)
                <a class="gallery-album-card" href="{{ route('galleries.show', $gallery->slug) }}"><div class="gallery-album-img"><img src="{{ $imageUrl($gallery->cover_image) }}" alt="{{ $gallery->title }}" loading="lazy"></div><div class="gallery-album-body"><h3>{{ $gallery->title }}</h3><p>{{ Str::limit(strip_tags($gallery->description), 100) }}</p><div class="gallery-album-meta"><span>{{ $gallery->images_count }} تصویر</span><span>{{ jalali_date($gallery->published_at) ?: '—' }}</span></div></div></a>
            @empty
                <a class="gallery-album-card" href="{{ route('galleries.index') }}"><div class="gallery-album-img"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="موردی موجود نیست" loading="lazy"></div><div class="gallery-album-body"><h3>موردی موجود نیست</h3><p>در حال حاضر گالری تصویری برای نمایش منتشر نشده است.</p><div class="gallery-album-meta"><span>۰ تصویر</span><span>—</span></div></div></a>
            @endforelse
        </div>
    </div>
</section>
