@extends('admin.layouts.app')
@section('title', 'تنظیمات هدر')
@section('content')
<div class="admin-page-toolbar"><div><p class="admin-eyebrow">تنظیمات</p><h2>تنظیمات هدر</h2></div></div>
<form class="admin-panel-card admin-form" action="{{ route('admin.header_settings.update') }}" method="POST" enctype="multipart/form-data">@csrf @method('PUT')
<div class="row g-3">
<div class="col-md-6"><label class="form-label">لوگوی هدر</label><input class="form-control" type="file" name="header_logo" accept="image/*">@if($settings->get('header.header_logo'))<small><a href="{{ Storage::url($settings->get('header.header_logo')) }}" target="_blank">مشاهده فعلی</a></small>@endif</div>
<div class="col-md-6"><label class="form-label">متن بالای هدر</label><input class="form-control" name="top_text" value="{{ old('top_text', $settings->get('header.top_text', 'اتاق اصناف شهرستان گرگان؛ پشتیبان کسب‌وکارهای صنفی')) }}"></div>
<div class="col-md-4"><label class="form-label">نمایش تاریخ بالای هدر</label><select class="form-control" name="top_date_enabled"><option value="1" @selected(old('top_date_enabled', (int)$settings->get('header.top_date_enabled', true)) == 1)>فعال</option><option value="0" @selected(old('top_date_enabled', (int)$settings->get('header.top_date_enabled', true)) == 0)>غیرفعال</option></select></div>
<div class="col-md-4"><label class="form-label">متن دکمه تماس</label><input class="form-control" name="contact_button_text" value="{{ old('contact_button_text', $settings->get('header.contact_button_text', 'تماس با اتاق')) }}"></div>
<div class="col-md-4"><label class="form-label">لینک دکمه تماس</label><input class="form-control" name="contact_button_link" value="{{ old('contact_button_link', $settings->get('header.contact_button_link', 'tel:01732152912')) }}" dir="ltr"></div>
<div class="col-md-6"><label class="form-label">متن دکمه خدمات</label><input class="form-control" name="service_button_text" value="{{ old('service_button_text', $settings->get('header.service_button_text', 'سامانه خدمات صنفی')) }}"></div>
<div class="col-md-6"><label class="form-label">لینک دکمه خدمات</label><input class="form-control" name="service_button_link" value="{{ old('service_button_link', $settings->get('header.service_button_link', route('systems.index'))) }}" dir="ltr"></div>
@foreach([1,2] as $i)
<div class="col-12"><hr><h4>لینک ویژه {{ $i }}</h4></div>
<div class="col-md-3"><label class="form-label">عنوان</label><input class="form-control" name="special_link_{{ $i }}_title" value="{{ old('special_link_'.$i.'_title', $settings->get('header.special_link_'.$i.'_title')) }}"></div>
<div class="col-md-3"><label class="form-label">URL</label><input class="form-control" name="special_link_{{ $i }}_url" value="{{ old('special_link_'.$i.'_url', $settings->get('header.special_link_'.$i.'_url')) }}" dir="ltr"></div>
<div class="col-md-2"><label class="form-label">آیکن</label><input class="form-control" name="special_link_{{ $i }}_icon" value="{{ old('special_link_'.$i.'_icon', $settings->get('header.special_link_'.$i.'_icon')) }}"></div>
<div class="col-md-2"><label class="form-label">رنگ</label><input class="form-control" name="special_link_{{ $i }}_color" value="{{ old('special_link_'.$i.'_color', $settings->get('header.special_link_'.$i.'_color')) }}"></div>
<div class="col-md-2"><label class="form-label">فعال</label><select class="form-control" name="special_link_{{ $i }}_active"><option value="1" @selected(old('special_link_'.$i.'_active', (int)$settings->get('header.special_link_'.$i.'_active', false)) == 1)>فعال</option><option value="0" @selected(old('special_link_'.$i.'_active', (int)$settings->get('header.special_link_'.$i.'_active', false)) == 0)>غیرفعال</option></select></div>
@endforeach
</div><div class="mt-3"><button class="admin-primary-btn">ذخیره تنظیمات هدر</button></div></form>
@endsection
