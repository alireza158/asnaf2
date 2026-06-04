@extends('admin.layouts.app')

@section('title', 'دسترسی‌ها')

@section('content')
<div class="admin-page-toolbar">
    <div>
        <p class="admin-eyebrow">مدیریت سطح دسترسی</p>
        <h2>دسترسی‌های سامانه</h2>
    </div>
    <a class="admin-primary-btn" href="{{ route('admin.permissions.create') }}">ایجاد دسترسی جدید</a>
</div>

<div class="admin-panel-card">
    <div class="table-responsive">
        <table class="table admin-table align-middle">
            <thead>
                <tr>
                    <th>عنوان</th>
                    <th>نام دسترسی</th>
                    <th>گروه</th>
                    <th>نقش‌های متصل</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($permissions as $permission)
                    <tr>
                        <td><strong>{{ $permission->label }}</strong></td>
                        <td><code>{{ $permission->name }}</code></td>
                        <td>{{ $permission->group }}</td>
                        <td>{{ $permission->roles_count }}</td>
                        <td>
                            <div class="admin-actions">
                                <a href="{{ route('admin.permissions.edit', $permission) }}">ویرایش</a>
                                <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('این دسترسی حذف شود؟')">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">هنوز دسترسی ثبت نشده است.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $permissions->links() }}
</div>
@endsection
