@php
    $marketTypes = ['gold', 'coin', 'silver', 'currency'];
    $marketItems = \App\Models\Price::query()
        ->active()
        ->whereIn('type', $marketTypes)
        ->where(function ($query) {
            $query->where('title', 'like', '%طلا%')
                ->orWhere('title', 'like', '%سکه%')
                ->orWhere('title', 'like', '%نقره%')
                ->orWhere('title', 'like', '%دلار%')
                ->orWhere('title', 'like', '%یورو%');
        })
        ->orderByRaw("CASE WHEN title LIKE '%طلا%' THEN 1 WHEN title LIKE '%سکه%' THEN 2 WHEN title LIKE '%نقره%' THEN 3 WHEN title LIKE '%دلار%' THEN 4 WHEN title LIKE '%یورو%' THEN 5 ELSE 9 END")
        ->orderBy('sort_order')
        ->orderBy('title')
        ->take(8)
        ->get();
@endphp
@if($marketItems->isNotEmpty())
<div class="market-ticker-wrap" aria-label="قیمت روز طلا و ارز">
    <div class="site-container market-ticker" data-market-ticker>
        <div class="market-ticker-title">قیمت روز طلا و ارز</div>
        <div class="market-ticker-items">
            @foreach($marketItems as $item)
                @php($lastUpdate = $item->fetched_at ?: $item->published_at ?: $item->updated_at)
                <div class="market-ticker-item {{ $loop->first ? 'is-active' : '' }}" data-market-item>
                    <strong>{{ $item->title }}</strong>
                    <span class="market-price">{{ fa_number($item->amount) }} {{ $item->unit }}</span>
                    <small>هر ۱ ساعت آپدیت می‌شود@if($lastUpdate) · آخرین بروزرسانی: {{ jalali_datetime($lastUpdate) }}@endif</small>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif
