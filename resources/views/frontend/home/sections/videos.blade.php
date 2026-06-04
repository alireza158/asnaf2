<section class="tourism-section" id="videos">
    <div class="site-container">
        <div class="section-heading"><h2>{{ $section->title }}</h2><a class="tab-pill" href="{{ route('videos.index') }}">آرشیو ویدیوها</a></div>
        <div class="tourism-grid">
            @forelse (($latestVideos ?? collect()) as $video)
                <div class="tourism-card"><a href="{{ route('videos.show', $video->slug) }}"><div class="tourism-img-wrap"><img alt="{{ $video->title }}" src="{{ $video->cover_image ? Storage::url($video->cover_image) : asset('assets/img/asnaf-gorgan-default.jpg') }}"/><div class="tourism-badge">{{ $video->type_label }}</div></div><div class="tourism-card-body"><h3>{{ $video->title }}</h3><p>{{ Str::limit(strip_tags($video->description), 100) ?: 'ویدیوی منتشرشده اتاق اصناف شهرستان گرگان' }}</p></div></a></div>
            @empty
                @foreach (['گزارش تصویری رویدادهای صنفی', 'آموزش مراحل دریافت پروانه کسب', 'گفت‌وگو با فعالان اتحادیه‌ها'] as $title)
                    <div class="tourism-card"><a href="{{ route('videos.index') }}"><div class="tourism-img-wrap"><img alt="{{ $title }}" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/><div class="tourism-badge">ویدیو</div></div><div class="tourism-card-body"><h3>{{ $title }}</h3><p>پس از تکمیل بانک ویدیو، محتوای پویا در این بخش نمایش داده می‌شود.</p></div></a></div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>
