@if (($systems ?? collect())->isNotEmpty())
<section class="fractions-section section-gray" id="systems">
    <div class="site-container">
        <div class="section-heading"><h2>{{ $section->title }}</h2><a class="tab-pill" href="{{ route('systems.index') }}">مشاهده همه سامانه‌ها</a></div>
        <div class="fraction-grid">
            @foreach ($systems as $system)
                <a href="{{ route('systems.show', $system->slug) }}" class="fraction-link"><span>{{ $system->icon ?: '💻' }}</span> {{ $system->title }}</a>
            @endforeach
        </div>
    </div>
</section>
@endif
