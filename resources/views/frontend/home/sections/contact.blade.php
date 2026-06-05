@php
    $settings = app(\App\Services\SettingService::class);
    $contactItems = collect($settings->get('footer.footer_contact_info', []))
        ->filter(fn ($item) => filled($item['text'] ?? null));
    $contactImage = $settings->get('footer.footer_contact_image') ?: $settings->get('site.contact_image') ?: $settings->get('site.site_logo');
@endphp
@if ($contactItems->isNotEmpty() || filled($section->content))
<section class="friendship-section section-white" id="contact">
    <div class="site-container">
        <div class="section-heading friendship-heading"><h2>{{ $section->title }}</h2><a class="tab-pill" href="{{ route('contact.create') }}">فرم تماس با ما</a></div>
        <div class="friendship-layout">
            @if ($contactImage)
                <div class="world-map-wrap"><img alt="{{ $settings->get('site.site_title', 'اتاق اصناف') }}" class="world-map-img" src="{{ Storage::url($contactImage) }}"/></div>
            @endif
            <aside class="friend-list"><div class="friend-scroll-wrap"><ul>
                @if (filled($section->content))
                    <li>{!! nl2br(e($section->content)) !!}</li>
                @endif
                @foreach ($contactItems as $item)
                    <li>{{ $item['icon'] ?? '•' }} {{ $item['text'] }}</li>
                @endforeach
            </ul></div></aside>
        </div>
    </div>
</section>
@endif
