@php($services = \App\Models\ElectronicService::query()->published()->orderBy('sort_order')->take(6)->get())
<section class="site-container howto-section">
    <div class="section-heading section-heading-centered">
        <h2>{{ $section->title }}</h2>
        <p>{{ $section->subtitle }}</p>
    </div>
    <div class="howto-grid">
        @forelse ($services as $service)
            <a class="howto-card" href="{{ route('electronic_services.show', $service->slug) }}">
                <div class="howto-icon">{{ $service->icon ?: '⚡' }}</div>
                <h3>{{ $service->title }}</h3>
                <p>{{ Str::limit($service->short_description ?: strip_tags($service->body), 100) ?: 'توضیحات این خدمت به‌زودی تکمیل می‌شود.' }}</p>
                <span class="howto-link">مشاهده ←</span>
            </a>
        @empty
            @foreach ([['📋','نحوه صدور پروانه کسب','راهنمای گام‌به‌گام دریافت پروانه کسب جدید'],['🔄','نحوه تمدید پروانه کسب','مراحل تمدید سالانه پروانه کسب و مدارک مورد نیاز'],['⚖️','ثبت شکایت صنفی','ثبت و پیگیری شکایات مردمی و گزارش تخلف']] as [$icon, $title, $text])
                <a class="howto-card" href="{{ route('electronic_services.index') }}"><div class="howto-icon">{{ $icon }}</div><h3>{{ $title }}</h3><p>{{ $text }}</p><span class="howto-link">مشاهده ←</span></a>
            @endforeach
        @endforelse
    </div>
    <div class="section-more-link mt-4"><a class="tab-pill" href="{{ route('electronic_services.index') }}">مشاهده همه خدمات</a></div>
</section>
