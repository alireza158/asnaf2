@php($commissions = \App\Models\Commission::query()->published()->orderBy('sort_order')->take(8)->get())

<section class="commissions-section ds-tint-block" id="commissions">
    <div class="site-container">
        <div class="section-heading"><h2>{{ $section->title }}</h2><a class="tab-pill" href="{{ route('commissions.index') }}">مشاهده همه کمیسیون‌ها</a></div>
        <div class="commission-card"><div class="commission-grid compact-grid">
            @forelse ($commissions as $index => $commission)
                <a class="commission-item {{ $index % 2 ? 'green' : 'blue' }}" href="{{ route('commissions.show', $commission->slug) }}"><strong>{{ $commission->title }}</strong><span>{{ Str::limit(strip_tags($commission->description), 90) ?: 'جزئیات کمیسیون' }}</span></a>
            @empty
                @foreach ([['صدور پروانه','ثبت، بررسی و راهنمای صدور پروانه کسب'],['تمدید پروانه','تمدید، تغییر نشانی و انتقال واحد صنفی'],['بازرسی','نظارت بر واحدهای صنفی و رعایت مقررات'],['شکایات','ثبت و پیگیری شکایات شهروندان']] as $index => [$title, $text])
                    <a class="commission-item {{ $index % 2 ? 'green' : 'blue' }}" href="{{ route('commissions.index') }}"><strong>{{ $title }}</strong><span>{{ $text }}</span></a>
                @endforeach
            @endforelse
        </div></div>
    </div>
</section>
