@extends('admin.layouts.app')

@section('title', 'قیمت روز طلا و ارز')

@section('content')
<div class="admin-page-toolbar">
    <div>
        <p class="admin-eyebrow">بازار</p>
        <h2>قیمت روز طلا و ارز</h2>
    </div>
    @if (request()->user()->hasPermission('market_prices.fetch'))
        <form action="{{ route('admin.market_prices.fetch') }}" method="POST">
            @csrf
            <button class="admin-primary-btn" type="submit">به‌روزرسانی دستی قیمت‌ها</button>
        </form>
    @endif
</div>

<div class="admin-panel-card mb-3">
    <p class="text-muted mb-0">قیمت‌ها هر یک ساعت از طریق scheduler به‌روزرسانی می‌شوند. برای اجرای خودکار روی سرور cron زیر باید تنظیم شود:</p>
    <code dir="ltr">* * * * * cd /path/to/project &amp;&amp; php artisan schedule:run &gt;&gt; /dev/null 2&gt;&amp;1</code>
</div>

<div class="admin-panel-card">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>عنوان</th>
                    <th>کلید</th>
                    <th>قیمت</th>
                    <th>تغییر</th>
                    <th>وضعیت</th>
                    <th>ترتیب</th>
                    <th>آخرین آپدیت</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($marketPrices as $item)
                <tr>
                    <td><strong>{{ $item->title }}</strong><br><small>{{ $item->category ?: '—' }}</small></td>
                    <td dir="ltr"><code>{{ $item->key }}</code></td>
                    <td>{{ is_null($item->price) ? '—' : number_format((float) $item->price) }} {{ $item->currency }}<br><small>{{ $item->unit ? 'برای هر '.$item->unit : '—' }}</small></td>
                    <td>
                        @if(!is_null($item->change_percent))
                            <span class="{{ $item->change_percent >= 0 ? 'text-success' : 'text-danger' }}">{{ $item->change_percent >= 0 ? '▲' : '▼' }} {{ abs((float) $item->change_percent) }}٪</span>
                        @else
                            —
                        @endif
                    </td>
                    <td><span class="admin-status-badge status-{{ $item->is_active ? 'active' : 'inactive' }}">{{ $item->is_active ? 'فعال' : 'غیرفعال' }}</span></td>
                    <td>{{ $item->sort_order }}</td>
                    <td>{{ optional($item->fetched_at)->format('Y/m/d H:i') ?? 'ثبت نشده' }}</td>
                    <td>
                        @if (request()->user()->hasPermission('market_prices.edit'))
                            <a class="admin-secondary-btn" href="{{ route('admin.market_prices.edit', $item) }}">ویرایش</a>
                        @else
                            —
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center text-muted">قیمتی ثبت نشده است.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
