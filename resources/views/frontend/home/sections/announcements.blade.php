<section class="fractions-section section-gray">
    <div class="site-container">
        <div class="section-heading"><h2>{{ $section->title }}</h2><a class="tab-pill" href="{{ route('announcements.index') }}">همه اطلاعیه‌ها</a></div>
        <div class="fraction-grid">
            @forelse (($importantAnnouncements ?? collect()) as $announcement)
                <a href="{{ route('announcements.show', $announcement->slug) }}" class="fraction-link">{{ $announcement->title }}</a>
            @empty
                @foreach (['بخشنامه‌های صنفی', 'فراخوان‌های آموزشی', 'اطلاعیه‌های کمیسیون نظارت', 'رویدادهای اتاق اصناف'] as $item)<a href="{{ route('announcements.index') }}" class="fraction-link">{{ $item }}</a>@endforeach
            @endforelse
        </div>
    </div>
</section>
