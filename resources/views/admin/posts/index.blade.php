@extends('admin.layouts.app')

@section('title', 'مدیریت اخبار')

@section('content')
<div class="admin-page-toolbar">
    <div><p class="admin-eyebrow">CMS اخبار</p><h2>مدیریت اخبار</h2></div>
    <a class="admin-primary-btn" href="{{ route('admin.posts.create') }}">ایجاد خبر جدید</a>
</div>

<div class="admin-panel-card mb-3">
    <form class="admin-search-form" action="{{ route('admin.posts.index') }}" method="GET">
        <label class="form-label mb-0" for="search">جستجو</label>
        <input class="form-control" id="search" name="search" value="{{ $search }}" placeholder="عنوان، اسلاگ یا خلاصه...">
        <select class="form-control" name="status" aria-label="فیلتر وضعیت">
            <option value="">همه وضعیت‌ها</option>
            @foreach (\App\Models\Post::STATUSES as $itemStatus)
                <option value="{{ $itemStatus }}" @selected($status === $itemStatus)>{{ $itemStatus }}</option>
            @endforeach
        </select>
        <select class="form-control" name="type" aria-label="فیلتر نوع">
            <option value="">همه نوع‌ها</option>
            @foreach (\App\Models\Post::TYPES as $itemType)
                <option value="{{ $itemType }}" @selected($type === $itemType)>{{ $itemType }}</option>
            @endforeach
        </select>
        <button class="admin-primary-btn" type="submit">اعمال</button>
        @if ($search !== '' || $status !== '' || $type !== '')<a class="admin-secondary-btn" href="{{ route('admin.posts.index') }}">حذف فیلتر</a>@endif
    </form>
</div>

<div class="admin-panel-card">
    <div class="table-responsive">
        <table class="table admin-table align-middle">
            <thead><tr><th>عنوان</th><th>دسته‌بندی</th><th>اتحادیه</th><th>نوع</th><th>وضعیت</th><th>بازدید</th><th>انتشار</th><th>عملیات</th></tr></thead>
            <tbody>
                @forelse ($posts as $post)
                    <tr>
                        <td><strong>{{ $post->title }}</strong><br><code>{{ $post->slug }}</code></td>
                        <td>{{ $post->category?->title ?: '—' }}</td>
                        <td>{{ $post->union?->name ?: 'عمومی' }}</td>
                        <td>{{ $post->type }}</td>
                        <td><span class="admin-status-badge status-{{ $post->status }}">{{ $post->status }}</span></td>
                        <td>{{ number_format($post->views_count) }}</td>
                        <td>{{ $post->published_at?->format('Y/m/d H:i') ?: '—' }}</td>
                        <td>
                            <div class="admin-actions">
                                <a href="{{ route('admin.posts.show', $post) }}">مشاهده</a>
                                <a href="{{ route('admin.posts.edit', $post) }}">ویرایش</a>
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST">@csrf @method('DELETE')<button type="submit" onclick="return confirm('این خبر حذف شود؟')">حذف</button></form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">خبری یافت نشد.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $posts->links() }}
</div>
@endsection
