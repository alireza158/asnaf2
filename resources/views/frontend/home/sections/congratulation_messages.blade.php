<section class="representatives-section section-white" id="congratulations">
    <div class="site-container">
        <div class="section-heading section-heading-centered"><h2>{{ $section->title }}</h2><p>{{ $section->subtitle ?: 'مناسبت‌ها و پیام‌های منتخب اتاق اصناف' }}</p></div>
        <div class="howto-grid">
            @foreach ([['🎉','تبریک مناسبت‌های ملی','پیام‌های مناسبتی مدیران و اتحادیه‌ها'],['🤝','قدردانی از فعالان صنفی','انعکاس موفقیت‌ها و همراهی کسبه'],['🌙','پیام‌های مذهبی و فرهنگی','اطلاع‌رسانی مناسبت‌های فرهنگی و اجتماعی']] as [$icon, $title, $text])
                <div class="howto-card"><div class="howto-icon">{{ $icon }}</div><h3>{{ $title }}</h3><p>{{ $text }}</p></div>
            @endforeach
        </div>
    </div>
</section>
