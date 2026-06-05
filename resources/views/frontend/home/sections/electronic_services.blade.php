@if (($electronicServices ?? collect())->isNotEmpty())
<section class="howto-section section-white" id="electronic-services">
    <div class="site-container">
        <div class="section-heading section-heading-centered"><h2>{{ $section->title }}</h2><p>{{ $section->subtitle }}</p></div>
        <div class="howto-grid">
        @foreach ($electronicServices as $service)
            @php
                $serviceHref = $service->link_type === 'external' && filled($service->link) && $service->link !== '#' ? $service->link : route('electronic-services.show', $service->slug);
                $serviceTarget = $service->link_type === 'external' ? ($service->target ?? '_blank') : '_self';
            @endphp
            <a class="howto-card" href="{{ $serviceHref }}" target="{{ $serviceTarget }}" @if($serviceTarget === '_blank') rel="noopener" @endif>
                <div class="howto-icon">{{ $service->icon ?: '⚡' }}</div><h3>{{ $service->title }}</h3><p>{{ $service->short_description ?: Str::limit(strip_tags($service->body), 120) }}</p><span class="howto-link">مشاهده خدمت ←</span>
            </a>
        @endforeach
        </div>
    <div class="section-more-link mt-4"><a class="tab-pill" href="{{ route('electronic-services.index') }}">مشاهده همه خدمات</a></div>
    </div>
</section>
@endif
