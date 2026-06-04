@extends('admin.layouts.app')

@section('title', 'مدیریت کاربران')

@section('content')
<div class="admin-page-toolbar">
    <div>
        <p class="admin-eyebrow">مدیریت کاربران</p>
        <h2>کاربران پنل مدیریت</h2>
    </div>
    <a class="admin-primary-btn" href="{{ route('admin.users.create') }}">ایجاد کاربر جدید</a>
</div>

<div class="admin-panel-card mb-3">
    <form class="admin-search-form" action="{{ route('admin.users.index') }}" method="GET">
        <label class="form-label mb-0" for="search">جستجو</label>
        <input class="form-control" id="search" name="search" value="{{ $search }}" placeholder="نام، ایمیل یا موبایل را وارد کنید...">
        <button class="admin-primary-btn" type="submit">جستجو</button>
        @if ($search !== '')
            <a class="admin-secondary-btn" href="{{ route('admin.users.index') }}">حذف فیلتر</a>
        @endif
    </form>
</div>

<div class="admin-panel-card">
    <div class="table-responsive">
        <table class="table admin-table align-middle">
            <thead>
                <tr>
                    <th>نام</th>
                    <th>ایمیل</th>
                    <th>شماره موبایل</th>
                    <th>نقش‌ها</th>
                    <th>اتحادیه مربوطه</th>
                    <th>وضعیت</th>
                    <th>تاریخ ایجاد</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td><strong>{{ $user->name }}</strong></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->mobile ?: '—' }}</td>
                        <td>
                            <div class="admin-badge-list">
                                @forelse ($user->roles as $role)
                                    <span>{{ $role->label }}</span>
                                @empty
                                    <em>بدون نقش</em>
                                @endforelse
                            </div>
                        </td>
                        <td>{{ $user->union?->name ?: '—' }}</td>
                        <td>
                            <span class="admin-status-badge {{ $user->is_active ? 'is-active' : 'is-inactive' }}">
                                {{ $user->is_active ? 'فعال' : 'غیرفعال' }}
                            </span>
                        </td>
                        <td>{{ $user->created_at?->format('Y/m/d') }}</td>
                        <td>
                            <div class="admin-actions">
                                <a href="{{ route('admin.users.show', $user) }}">مشاهده</a>
                                <a href="{{ route('admin.users.edit', $user) }}">ویرایش</a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('این کاربر حذف شود؟')">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">کاربری با این مشخصات پیدا نشد.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $users->links() }}
</div>
@endsection
