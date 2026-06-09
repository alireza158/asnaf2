@extends('admin.layouts.app')

@section('title', 'داشبورد مدیریت')

@section('content')
<section class="admin-welcome-card">
    <div>
        <p class="admin-eyebrow">نمای کلی امروز</p>
        <h2>به پنل مدیریت اتاق اصناف مرکز استان گلستان خوش آمدید</h2>
        <p>از این بخش می‌توانید وضعیت محتوای سایت، پیام‌ها، شکایات و فعالیت‌های مهم را به‌صورت خلاصه مشاهده کنید.</p>
    </div>
    <div class="admin-date-card">
        <span>امروز</span>
        <strong>{{ jalali_text_date(now('Asia/Tehran')) }}</strong>
    </div>
</section>

<section class="admin-stats-grid" aria-label="آمار کلی پنل مدیریت">
    <article class="admin-stat-card stat-warning">
        <div class="admin-stat-icon">✅</div>
        <div>
            <span>محتواهای در انتظار تایید</span>
            <strong>{{ $pendingApprovals->count() }}</strong>
        </div>
    </article>

    <article class="admin-stat-card stat-danger">
        <div class="admin-stat-icon">📨</div>
        <div>
            <span>شکایت‌های جدید</span>
            <strong>۸</strong>
        </div>
    </article>

    <article class="admin-stat-card stat-primary">
        <div class="admin-stat-icon">🏢</div>
        <div>
            <span>تعداد اتحادیه‌ها</span>
            <strong>۴۶</strong>
        </div>
    </article>

    <article class="admin-stat-card stat-success">
        <div class="admin-stat-icon">🤝</div>
        <div>
            <span>تعداد اعضا</span>
            <strong>۲,۸۴۰</strong>
        </div>
    </article>

    <article class="admin-stat-card stat-info">
        <div class="admin-stat-icon">☎️</div>
        <div>
            <span>پیام‌های تماس خوانده‌نشده</span>
            <strong>{{ $unreadContactMessagesCount }}</strong>
        </div>
    </article>

    <article class="admin-stat-card stat-purple">
        <div class="admin-stat-icon">💬</div>
        <div>
            <span>پیامک‌های ارسال‌شده</span>
            <strong>۱,۲۵۰</strong>
        </div>
    </article>
</section>

<section class="admin-dashboard-grid">
    <div class="admin-panel-card">
        <div class="admin-panel-header">
            <h3>کارهای پیشنهادی امروز</h3>
            <span>اولویت‌دار</span>
        </div>
        <ul class="admin-task-list">
            <li><span></span>بررسی و تایید خبرهای جدید</li>
            <li><span></span>پاسخ به شکایت‌های ثبت‌شده امروز</li>
            <li><span></span>بازبینی پیام‌های فرم تماس</li>
            <li><span></span>به‌روزرسانی اطلاعیه‌های صفحه اصلی</li>
        </ul>
    </div>


    <div class="admin-panel-card">
        <div class="admin-panel-header">
            <h3>محتواهای در انتظار تایید</h3>
            <a href="{{ route('admin.pending_approvals.index') }}" class="btn btn-sm btn-outline-primary">مشاهده همه</a>
        </div>
        @if($pendingApprovals->isNotEmpty())
            <div class="admin-status-list">
                @foreach($pendingApprovals as $item)
                    <div>
                        <span>{{ $item['label'] }} - {{ $item['title'] }}</span>
                        @if($item['show_url'])
                            <a href="{{ $item['show_url'] }}" class="btn btn-sm btn-light">مشاهده</a>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted mb-0">در حال حاضر محتوایی برای تایید وجود ندارد.</p>
        @endif
    </div>

    <div class="admin-panel-card">
        <div class="admin-panel-header">
            <h3>آخرین وضعیت سامانه</h3>
            <span>نمونه</span>
        </div>
        <div class="admin-status-list">
            <div><span>وضعیت سایت</span><strong class="text-success">فعال</strong></div>
            <div><span>وضعیت پیامک</span><strong class="text-success">متصل</strong></div>
            <div><span>آخرین پشتیبان‌گیری</span><strong>دیروز، ۲۳:۳۰</strong></div>
            <div><span>محتوای منتشرشده این ماه</span><strong>۳۷ مورد</strong></div>
        </div>
    </div>
</section>
@endsection
