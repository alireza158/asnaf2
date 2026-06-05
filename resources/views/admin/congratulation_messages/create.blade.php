@extends('admin.layouts.app')

@section('title', 'ایجاد پیام تبریک')

@section('content')
<div class="admin-page-toolbar"><div><p class="admin-eyebrow">پیام‌های تبریک</p><h2>ایجاد پیام تبریک جدید</h2></div><a class="admin-secondary-btn" href="{{ route('admin.congratulation_messages.index') }}">بازگشت</a></div>
<form class="admin-panel-card admin-form" action="{{ route('admin.congratulation_messages.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row g-3">
<div class="col-md-6"><label class="form-label">عنوان</label><input class="form-control" name="title" value="{{ old('title') }}" required></div>
<div class="col-md-6"><label class="form-label">نامک</label><input class="form-control" name="slug" value="{{ old('slug') }}" dir="ltr"><small class="text-muted">اگر خالی بماند از عنوان ساخته می‌شود.</small></div>
<div class="col-md-4"><label class="form-label">اتحادیه</label><select class="form-control" name="union_id"><option value="">پیام عمومی</option>@foreach($unions as $union)<option value="{{ $union->id }}" @selected((string)old('union_id')===(string)$union->id)>{{ $union->display_title }}</option>@endforeach</select></div>
<div class="col-md-4"><label class="form-label">نام مدیر</label><input class="form-control" name="manager_name" value="{{ old('manager_name') }}"></div>
<div class="col-md-4"><label class="form-label">سمت مدیر</label><input class="form-control" name="manager_position" value="{{ old('manager_position') }}"></div>
<div class="col-md-4"><label class="form-label">تصویر مدیر</label><input class="form-control" type="file" name="manager_image" accept="image/*"></div>
<div class="col-md-4"><label class="form-label">نمایش در صفحه اصلی</label><select class="form-control" name="show_on_home"><option value="1" @selected(old('show_on_home')==='1')>بله</option><option value="0" @selected(old('show_on_home','0')==='0')>خیر</option></select></div>
<div class="col-md-4"><label class="form-label">نمایش در صفحه اتحادیه</label><select class="form-control" name="show_on_union_page"><option value="1" @selected(old('show_on_union_page')==='1')>بله</option><option value="0" @selected(old('show_on_union_page','0')==='0')>خیر</option></select></div>
<div class="col-md-4"><label class="form-label">وضعیت</label><select class="form-control" name="status">@foreach($statusLabels as $value=>$label)<option value="{{ $value }}" @selected(old('status','draft')===$value)>{{ $label }}</option>@endforeach</select></div>
<div class="col-md-4"><label class="form-label">تاریخ انتشار</label><input class="form-control" type="datetime-local" name="published_at" value="{{ old('published_at') }}"></div>
<div class="col-md-4"><label class="form-label">دلیل رد</label><input class="form-control" name="rejected_reason" value="{{ old('rejected_reason') }}"></div>
<div class="col-md-6"><label class="form-label">ترتیب نمایش</label><input class="form-control" type="number" name="sort_order" value="{{ old('sort_order',0) }}" min="0"></div>
<div class="col-md-6"><label class="form-label">فعال</label><select class="form-control" name="is_active"><option value="1" @selected(old('is_active','1')==='1')>فعال</option><option value="0" @selected(old('is_active')==='0')>غیرفعال</option></select></div>
<div class="col-12"><label class="form-label">متن پیام</label><textarea class="form-control js-rich-editor" name="body" rows="12">{{ old('body') }}</textarea></div>
</div>
<div class="mt-3 d-flex gap-2"><button class="admin-primary-btn">ذخیره پیام</button><a class="admin-secondary-btn" href="{{ route('admin.congratulation_messages.index') }}">انصراف</a></div>
</form>
@endsection
@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>document.querySelectorAll('.js-rich-editor').forEach((el) => ClassicEditor.create(el, {language: 'fa'}).catch(console.error));</script>
@endpush
