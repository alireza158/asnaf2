@if (($electronicServices ?? collect())->isNotEmpty())
<section class="site-container howto-section">
    <div class="section-heading section-heading-centered">
        <h2>{{ $section->title }}</h2>
        @if($section->subtitle)<p>{{ $section->subtitle }}</p>@endif
    </div>
    <div class="howto-grid">
        @foreach ($electronicServices as $service)
            <a class="howto-card" href="{{ route('electronic_services.show', $service->slug) }}">
                <div class="howto-icon">{{ $service->icon ?: '⚡' }}</div>
                <h3>{{ $service->title }}</h3>
                <p>{{ Str::limit($service->short_description ?: strip_tags($service->body), 100) }}</p>
                <span class="howto-link">مشاهده ←</span>
            </a>
        @endforeach
    </div>
    <div class="section-more-link mt-4"><a class="tab-pill" href="{{ route('electronic_services.index') }}">مشاهده همه خدمات</a></div>
</section>
@endif
