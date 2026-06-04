<section class="representatives-section section-white" id="galleries">
    <div class="site-container">
        <div class="section-heading"><h2>{{ $section->title }}</h2><a class="tab-pill" href="{{ route('galleries.index') }}">گالری تصاویر</a></div>
        <div class="gallery-albums-grid">
            @foreach (['جلسات اتاق اصناف', 'رویدادهای آموزشی', 'بازدیدهای صنفی'] as $title)
                <a class="gallery-album-card" href="{{ route('galleries.show', Str::slug($title)) }}"><div class="gallery-album-img"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="{{ $title }}"></div><div class="gallery-album-body"><h3>{{ $title }}</h3><p>نمایش تصاویر منتخب پس از تکمیل گالری پویا.</p></div></a>
            @endforeach
        </div>
    </div>
</section>
