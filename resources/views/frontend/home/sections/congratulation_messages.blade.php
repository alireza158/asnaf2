@php($messages = \App\Models\CongratulationMessage::query()->forHome()->with('union')->orderBy('sort_order')->latest('published_at')->take(3)->get())
<section class="representatives-section section-white" id="congratulations">
    <div class="site-container">
        <div class="section-heading section-heading-centered"><h2>{{ $section->title }}</h2><p>{{ $section->subtitle ?: 'مناسبت‌ها و پیام‌های منتخب اتاق اصناف' }}</p></div>
        <div class="howto-grid">
            @forelse ($messages as $message)
                <a class="howto-card" href="{{ route('congratulation_messages.show', $message->slug) }}"><div class="howto-icon">🎉</div><h3>{{ $message->title }}</h3><p>{{ Str::limit(strip_tags($message->body), 120) ?: ($message->union?->display_title ?: 'پیام مناسبتی') }}</p><span class="howto-link">مشاهده پیام ←</span></a>
            @empty
                @foreach ([['🎉','تبریک مناسبت‌های ملی','پیام‌های مناسبتی مدیران و اتحادیه‌ها'],['🤝','قدردانی از فعالان صنفی','انعکاس موفقیت‌ها و همراهی کسبه'],['🌙','پیام‌های مذهبی و فرهنگی','اطلاع‌رسانی مناسبت‌های فرهنگی و اجتماعی']] as [$icon, $title, $text])
                    <div class="howto-card"><div class="howto-icon">{{ $icon }}</div><h3>{{ $title }}</h3><p>{{ $text }}</p></div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>
