@php($systems = \App\Models\System::query()->published()->orderBy('sort_order')->take(6)->get())

<section class="fractions-section section-gray" id="systems">
    <div class="site-container">
        <div class="section-heading"><h2>{{ $section->title }}</h2><a class="tab-pill" href="{{ route('systems.index') }}">مشاهده همه سامانه‌ها</a></div>
        <div class="fraction-grid">
            @forelse ($systems as $system)
                <a href="{{ route('systems.show', $system->slug) }}" class="fraction-link"><span>{{ $system->icon ?: '💻' }}</span> {{ $system->title }}</a>
            @empty
                @foreach (['سامانه نوین اصناف', 'سامانه آموزش اصناف', 'درگاه ملی مجوزها', 'سامانه شکایات', 'استعلام پروانه کسب', 'فرم‌ها و درخواست‌ها'] as $item)
                    <a href="{{ route('systems.index') }}" class="fraction-link">{{ $item }}</a>
                @endforeach
            @endforelse
        </div>
    </div>
</section>
