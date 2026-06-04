@extends('admin.layouts.app')

@section('title', 'نقش‌ها و دسترسی‌ها')

@section('content')
<div class="admin-page-toolbar">
    <div>
        <p class="admin-eyebrow">مدیریت نقش‌ها</p>
        <h2>نقش‌های سامانه</h2>
    </div>
    <div class="admin-actions">
        <a href="{{ route('admin.permissions.index') }}">مدیریت دسترسی‌ها</a>
        <a class="admin-primary-btn" href="{{ route('admin.roles.create') }}">ایجاد نقش جدید</a>
    </div>
</div>

<div class="admin-panel-card">
    <div class="table-responsive">
        <table class="table admin-table align-middle">
            <thead>
                <tr>
                    <th>عنوان</th>
                    <th>نام سیستمی</th>
                    <th>تعداد دسترسی‌ها</th>
                    <th>تعداد کاربران</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $role)
                    <tr>
                        <td><strong>{{ $role->label }}</strong></td>
                        <td><code>{{ $role->name }}</code></td>
                        <td>{{ $role->permissions_count }}</td>
                        <td>{{ $role->users_count }}</td>
                        <td>
                            <div class="admin-actions">
                                <a href="{{ route('admin.roles.show', $role) }}">مشاهده</a>
                                <a href="{{ route('admin.roles.edit', $role) }}">ویرایش</a>
                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('این نقش حذف شود؟')">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">هنوز نقشی ثبت نشده است.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $roles->links() }}
</div>
@endsection
