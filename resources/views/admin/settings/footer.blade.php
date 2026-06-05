@extends('admin.layouts.app')
@section('title', 'تنظیمات فوتر')
@section('content')
<div class="admin-page-toolbar"><div><p class="admin-eyebrow">تنظیمات</p><h2>تنظیمات فوتر</h2></div></div>
<form class="admin-panel-card admin-form" action="{{ route('admin.footer_settings.update') }}" method="POST" enctype="multipart/form-data">@csrf @method('PUT')
<div class="row g-3">
<div class="col-md-6"><label class="form-label">لوگوی فوتر</label><input class="form-control" type="file" name="footer_logo" accept="image/*">@if($settings->get('footer.footer_logo'))<small><a href="{{ Storage::url($settings->get('footer.footer_logo')) }}" target="_blank">مشاهده فعلی</a></small>@endif</div>
<div class="col-md-6"><label class="form-label">متن کپی‌رایت</label><input class="form-control" name="copyright_text" value="{{ old('copyright_text', $settings->get('footer.copyright_text', 'تمام حقوق مادی و معنوی این وبسایت متعلق به اتاق اصناف شهرستان گرگان می‌باشد')) }}"></div>
<div class="col-12"><label class="form-label">توضیحات فوتر</label><textarea class="form-control js-rich-editor" name="footer_description" rows="4">{{ old('footer_description', $settings->get('footer.footer_description')) }}</textarea></div>
<div class="col-12"><label class="form-label">ستون‌های فوتر (JSON)</label><textarea class="form-control" name="footer_columns" rows="8" dir="ltr">{{ old('footer_columns', json_encode($settings->get('footer.footer_columns', []), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)) }}</textarea><small class="text-muted">مثال: [{"title":"دسترسی سریع","links":[{"title":"خانه","url":"/"}]}]</small></div>
<div class="col-12"><label class="form-label">اطلاعات تماس فوتر (JSON)</label><textarea class="form-control" name="footer_contact_info" rows="5" dir="ltr">{{ old('footer_contact_info', json_encode($settings->get('footer.footer_contact_info', []), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)) }}</textarea></div>
<div class="col-12"><label class="form-label">شبکه‌های اجتماعی فوتر (JSON)</label><textarea class="form-control" name="footer_social_links" rows="5" dir="ltr">{{ old('footer_social_links', json_encode($settings->get('footer.footer_social_links', []), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)) }}</textarea></div>
</div><div class="mt-3"><button class="admin-primary-btn">ذخیره تنظیمات فوتر</button></div></form>
@endsection
