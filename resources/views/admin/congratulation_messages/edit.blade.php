@extends('admin.layouts.app')

@section('title', 'ویرایش پیام تبریک')

@section('content')
<div class="admin-page-toolbar"><div><p class="admin-eyebrow">پیام‌های تبریک</p><h2>ویرایش {{ $message->title }}</h2></div><a class="admin-secondary-btn" href="{{ route('admin.congratulation_messages.show', $message) }}">بازگشت</a></div>
<form class="admin-panel-card admin-form" action="{{ route('admin.congratulation_messages.update', $message) }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')
<div class="row g-3">
<div class="col-md-6"><label class="form-label">عنوان</label><input class="form-control" name="title" value="{{ old('title',$message->title) }}" required></div>
<div class="col-md-6"><label class="form-label">نامک</label><input class="form-control" name="slug" value="{{ old('slug',$message->slug) }}" dir="ltr"></div>
<div class="col-md-4"><label class="form-label">اتحادیه</label><select class="form-control" name="union_id"><option value="">پیام عمومی</option>@foreach($unions as $union)<option value="{{ $union->id }}" @selected((string)old('union_id',$message->union_id)===(string)$union->id)>{{ $union->display_title }}</option>@endforeach</select></div>
<div class="col-md-4"><label class="form-label">نام مدیر</label><input class="form-control" name="manager_name" value="{{ old('manager_name',$message->manager_name) }}"></div>
<div class="col-md-4"><label class="form-label">سمت مدیر</label><input class="form-control" name="manager_position" value="{{ old('manager_position',$message->manager_position) }}"></div>
<div class="col-md-4"><label class="form-label">تصویر مدیر جدید</label><input class="form-control" type="file" name="manager_image" accept="image/*">@if($message->manager_image)<small><a href="{{ Storage::url($message->manager_image) }}" target="_blank">مشاهده فعلی</a></small>@endif</div>
<div class="col-md-4"><label class="form-label">نمایش در صفحه اصلی</label><select class="form-control" name="show_on_home"><option value="1" @selected((string)old('show_on_home',(int)$message->show_on_home)==='1')>بله</option><option value="0" @selected((string)old('show_on_home',(int)$message->show_on_home)==='0')>خیر</option></select></div>
<div class="col-md-4"><label class="form-label">نمایش در صفحه اتحادیه</label><select class="form-control" name="show_on_union_page"><option value="1" @selected((string)old('show_on_union_page',(int)$message->show_on_union_page)==='1')>بله</option><option value="0" @selected((string)old('show_on_union_page',(int)$message->show_on_union_page)==='0')>خیر</option></select></div>
<div class="col-md-4"><label class="form-label">وضعیت</label><select class="form-control" name="status">@foreach($statusLabels as $value=>$label)<option value="{{ $value }}" @selected(old('status',$message->status)===$value)>{{ $label }}</option>@endforeach</select></div>
<div class="col-md-4"><label class="form-label">تاریخ انتشار</label><input class="form-control" type="datetime-local" name="published_at" value="{{ old('published_at',$message->published_at?->format('Y-m-d\TH:i')) }}"></div>
<div class="col-md-4"><label class="form-label">دلیل رد</label><input class="form-control" name="rejected_reason" value="{{ old('rejected_reason',$message->rejected_reason) }}"></div>
<div class="col-md-6"><label class="form-label">ترتیب نمایش</label><input class="form-control" type="number" name="sort_order" value="{{ old('sort_order',$message->sort_order) }}" min="0"></div>
<div class="col-md-6"><label class="form-label">فعال</label><select class="form-control" name="is_active"><option value="1" @selected((string)old('is_active',(int)$message->is_active)==='1')>فعال</option><option value="0" @selected((string)old('is_active',(int)$message->is_active)==='0')>غیرفعال</option></select></div>
<div class="col-12"><label class="form-label">متن پیام</label><textarea class="form-control js-rich-editor" name="body" rows="12">{{ old('body',$message->body) }}</textarea></div>
</div>
<div class="mt-3 d-flex gap-2"><button class="admin-primary-btn">ذخیره تغییرات</button><a class="admin-secondary-btn" href="{{ route('admin.congratulation_messages.show', $message) }}">انصراف</a></div>
</form>
@endsection
@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>document.querySelectorAll('.js-rich-editor').forEach((el) => ClassicEditor.create(el, {language: 'fa'}).catch(console.error));</script>
@endpush
