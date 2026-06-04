@extends('admin.layouts.app')

@section('title', 'جزئیات خبر')

@section('content')
<div class="admin-page-toolbar">
    <div><p class="admin-eyebrow">جزئیات خبر</p><h2>{{ $post->title }}</h2></div>
    <div class="d-flex gap-2 flex-wrap">
        <a class="admin-secondary-btn" href="{{ route('admin.posts.index') }}">بازگشت</a>
        <a class="admin-primary-btn" href="{{ route('admin.posts.edit', $post) }}">ویرایش</a>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="admin-panel-card">
            @if ($post->featured_image)
                <img class="img-fluid rounded mb-3" src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}">
            @endif
            <p class="text-muted">{{ $post->excerpt }}</p>
            <div class="admin-rich-content">{!! $post->body !!}</div>
        </div>
        @if ($post->galleries->isNotEmpty())
            <div class="admin-panel-card mt-3">
                <h3 class="h5 mb-3">گالری خبر</h3>
                <div class="row g-3">
                    @foreach ($post->galleries as $gallery)
                        <div class="col-md-4">
                            <img class="img-fluid rounded" src="{{ Storage::url($gallery->image) }}" alt="{{ $gallery->caption ?: $post->title }}">
                            @if ($gallery->caption)<p class="small mt-2 mb-0">{{ $gallery->caption }}</p>@endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    <div class="col-lg-4">
        <div class="admin-panel-card">
            <dl class="row mb-0">
                <dt class="col-5">وضعیت</dt><dd class="col-7"><span class="admin-status-badge status-{{ $post->status }}">{{ $post->status }}</span></dd>
                <dt class="col-5">نوع</dt><dd class="col-7">{{ $post->type }}</dd>
                <dt class="col-5">دسته‌بندی</dt><dd class="col-7">{{ $post->category?->title ?: '—' }}</dd>
                <dt class="col-5">اتحادیه</dt><dd class="col-7">{{ $post->union?->name ?: 'عمومی' }}</dd>
                <dt class="col-5">مهم</dt><dd class="col-7">{{ $post->is_important ? 'بله' : 'خیر' }}</dd>
                <dt class="col-5">ویژه</dt><dd class="col-7">{{ $post->is_featured ? 'بله' : 'خیر' }}</dd>
                <dt class="col-5">فعال</dt><dd class="col-7">{{ $post->is_active ? 'بله' : 'خیر' }}</dd>
                <dt class="col-5">بازدید</dt><dd class="col-7">{{ number_format($post->views_count) }}</dd>
                <dt class="col-5">نویسنده</dt><dd class="col-7">{{ $post->author?->name ?: '—' }}</dd>
                <dt class="col-5">تاییدکننده</dt><dd class="col-7">{{ $post->approver?->name ?: '—' }}</dd>
                <dt class="col-5">انتشار</dt><dd class="col-7">{{ $post->published_at?->format('Y/m/d H:i') ?: '—' }}</dd>
            </dl>
        </div>
        @if ($post->rejected_reason)
            <div class="admin-panel-card mt-3"><strong>دلیل رد:</strong><p class="mb-0 mt-2">{{ $post->rejected_reason }}</p></div>
        @endif
        <div class="admin-panel-card mt-3">
            <h3 class="h6">اقدام مدیریتی</h3>
            <div class="d-flex gap-2 flex-wrap mb-3">
                <form action="{{ route('admin.posts.approve', $post) }}" method="POST">@csrf @method('PATCH')<button class="admin-secondary-btn" type="submit">تایید</button></form>
                <form action="{{ route('admin.posts.publish', $post) }}" method="POST">@csrf @method('PATCH')<button class="admin-primary-btn" type="submit">انتشار</button></form>
            </div>
            <form action="{{ route('admin.posts.reject', $post) }}" method="POST">
                @csrf
                @method('PATCH')
                <label class="form-label" for="rejected_reason">دلیل رد خبر</label>
                <textarea class="form-control mb-2" id="rejected_reason" name="rejected_reason" rows="3" required>{{ old('rejected_reason') }}</textarea>
                <button class="admin-secondary-btn" type="submit">رد خبر</button>
            </form>
        </div>
    </div>
</div>
@endsection
