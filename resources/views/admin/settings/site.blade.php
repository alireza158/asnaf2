@extends('admin.layouts.app')
@section('title', 'تنظیمات سایت')
@section('content')
<div class="admin-page-toolbar"><div><p class="admin-eyebrow">تنظیمات</p><h2>تنظیمات عمومی سایت</h2></div></div>
<form class="admin-panel-card admin-form" action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">@csrf @method('PUT')
<div class="row g-3">
<div class="col-md-6"><label class="form-label">عنوان سایت</label><input class="form-control" name="site_title" value="{{ old('site_title', $settings->get('site.site_title', 'اتاق اصناف شهرستان گرگان')) }}"></div>
<div class="col-md-6"><label class="form-label">عنوان متای پیش‌فرض</label><input class="form-control" name="default_meta_title" value="{{ old('default_meta_title', $settings->get('site.default_meta_title')) }}"></div>
<div class="col-12"><label class="form-label">توضیح سایت</label><textarea class="form-control js-rich-editor" name="site_description" rows="3">{{ old('site_description', $settings->get('site.site_description')) }}</textarea></div>
<div class="col-12"><label class="form-label">توضیح متای پیش‌فرض</label><textarea class="form-control" name="default_meta_description" rows="3">{{ old('default_meta_description', $settings->get('site.default_meta_description')) }}</textarea></div>
<div class="col-md-6"><label class="form-label">لوگو</label><input class="form-control" type="file" name="site_logo" accept="image/*">@if($settings->get('site.site_logo'))<small><a href="{{ Storage::url($settings->get('site.site_logo')) }}" target="_blank">مشاهده فعلی</a></small>@endif</div>
<div class="col-md-6"><label class="form-label">فاوآیکن</label><input class="form-control" type="file" name="site_favicon" accept="image/*">@if($settings->get('site.site_favicon'))<small><a href="{{ Storage::url($settings->get('site.site_favicon')) }}" target="_blank">مشاهده فعلی</a></small>@endif</div>
<div class="col-md-4"><label class="form-label">تلفن</label><input class="form-control" name="phone" value="{{ old('phone', $settings->get('site.phone')) }}"></div>
<div class="col-md-4"><label class="form-label">موبایل</label><input class="form-control" name="mobile" value="{{ old('mobile', $settings->get('site.mobile')) }}"></div>
<div class="col-md-4"><label class="form-label">ایمیل</label><input class="form-control" name="email" value="{{ old('email', $settings->get('site.email')) }}" dir="ltr"></div>
<div class="col-12"><label class="form-label">آدرس</label><textarea class="form-control" name="address" rows="2">{{ old('address', $settings->get('site.address')) }}</textarea></div>
<div class="col-12"><label class="form-label">لینک نقشه</label><input class="form-control" name="map_url" value="{{ old('map_url', $settings->get('site.map_url')) }}" dir="ltr"></div>
<div class="col-12"><label class="form-label">شبکه‌های اجتماعی (JSON)</label><textarea class="form-control" name="social_links" rows="5" dir="ltr">{{ old('social_links', json_encode($settings->get('site.social_links', []), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)) }}</textarea><small class="text-muted">مثال: [{"title":"تلگرام","url":"https://...","icon":"✈️"}]</small></div>
</div><div class="mt-3"><button class="admin-primary-btn">ذخیره تنظیمات</button></div></form>
@endsection
