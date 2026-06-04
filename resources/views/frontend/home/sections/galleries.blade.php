<section class="representatives-section section-white" id="galleries">
    <div class="site-container">
        <div class="section-heading"><h2>{{ $section->title }}</h2><a class="tab-pill" href="{{ route('galleries.index') }}">گالری تصاویر</a></div>
        <div class="gallery-albums-grid">
            @forelse (($latestGalleries ?? collect()) as $gallery)
                <a class="gallery-album-card" href="{{ route('galleries.show', $gallery->slug) }}"><div class="gallery-album-img"><img src="{{ $gallery->cover_image ? Storage::url($gallery->cover_image) : asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="{{ $gallery->title }}"></div><div class="gallery-album-body"><h3>{{ $gallery->title }}</h3><p>{{ Str::limit(strip_tags($gallery->description), 100) ?: 'گالری تصاویر اتاق اصناف شهرستان گرگان' }}</p><div class="gallery-album-meta"><span>{{ $gallery->images_count }} تصویر</span><span>{{ $gallery->published_at?->format('Y/m/d') ?: '—' }}</span></div></div></a>
            @empty
                @foreach (['جلسات اتاق اصناف', 'رویدادهای آموزشی', 'بازدیدهای صنفی'] as $title)
                    <a class="gallery-album-card" href="{{ route('galleries.index') }}"><div class="gallery-album-img"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="{{ $title }}"></div><div class="gallery-album-body"><h3>{{ $title }}</h3><p>پس از انتشار گالری‌ها، تصاویر پویا در این بخش نمایش داده می‌شود.</p></div></a>
                @endforeach
            @endforelse
        </div>
    </div>
</section>
