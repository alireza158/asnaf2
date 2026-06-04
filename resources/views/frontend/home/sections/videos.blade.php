<section class="tourism-section" id="videos">
    <div class="site-container">
        <div class="section-heading"><h2>{{ $section->title }}</h2><a class="tab-pill" href="{{ route('videos.show', 'intro') }}">آرشیو ویدیوها</a></div>
        <div class="tourism-grid">
            @foreach (['گزارش تصویری رویدادهای صنفی', 'آموزش مراحل دریافت پروانه کسب', 'گفت‌وگو با فعالان اتحادیه‌ها'] as $title)
                <div class="tourism-card"><a href="{{ route('videos.show', Str::slug($title)) }}"><div class="tourism-img-wrap"><img alt="{{ $title }}" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/><div class="tourism-badge">ویدیو</div></div><div class="tourism-card-body"><h3>{{ $title }}</h3><p>پس از تکمیل بانک ویدیو، محتوای پویا در این بخش نمایش داده می‌شود.</p></div></a></div>
            @endforeach
        </div>
    </div>
</section>
