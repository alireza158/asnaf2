@if (($commissions ?? collect())->isNotEmpty())
<section class="commissions-section ds-tint-block" id="commissions">
    <div class="site-container">
        <div class="section-heading"><h2>{{ $section->title }}</h2><a class="tab-pill" href="{{ route('commissions.index') }}">مشاهده همه کمیسیون‌ها</a></div>
        <div class="commission-card"><div class="commission-grid compact-grid">
            @foreach ($commissions as $index => $commission)
                <a class="commission-item {{ $index % 2 ? 'green' : 'blue' }}" href="{{ route('commissions.show', $commission->slug) }}"><strong>{{ $commission->title }}</strong><span>{{ Str::limit(strip_tags($commission->description), 90) ?: $commission->sessions_count.' جلسه منتشرشده' }}</span></a>
            @endforeach
        </div></div>
    </div>
</section>
@endif
