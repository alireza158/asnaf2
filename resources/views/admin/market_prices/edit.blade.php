@extends('admin.layouts.app')

@section('title', 'ویرایش قیمت')

@section('content')
<div class="admin-page-toolbar">
    <div>
        <p class="admin-eyebrow">بازار</p>
        <h2>ویرایش {{ $marketPrice->title }}</h2>
    </div>
    <a class="admin-secondary-btn" href="{{ route('admin.market_prices.index') }}">بازگشت</a>
</div>

<form class="admin-panel-card admin-form" action="{{ route('admin.market_prices.update', $marketPrice) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row g-3">
        <div class="col-md-6"><label class="form-label" for="title">عنوان</label><input class="form-control" id="title" name="title" value="{{ old('title', $marketPrice->title) }}" required></div>
        <div class="col-md-6"><label class="form-label" for="key">کلید</label><input class="form-control" id="key" value="{{ $marketPrice->key }}" dir="ltr" disabled></div>
        <div class="col-md-4"><label class="form-label" for="category">دسته‌بندی</label><input class="form-control" id="category" name="category" value="{{ old('category', $marketPrice->category) }}"></div>
        <div class="col-md-4"><label class="form-label" for="price">قیمت</label><input class="form-control" id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price', $marketPrice->price) }}"></div>
        <div class="col-md-4"><label class="form-label" for="currency">واحد پول</label><input class="form-control" id="currency" name="currency" value="{{ old('currency', $marketPrice->currency) }}" required></div>
        <div class="col-md-4"><label class="form-label" for="unit">واحد</label><input class="form-control" id="unit" name="unit" value="{{ old('unit', $marketPrice->unit) }}"></div>
        <div class="col-md-4"><label class="form-label" for="change_amount">مقدار تغییر</label><input class="form-control" id="change_amount" name="change_amount" type="number" step="0.01" value="{{ old('change_amount', $marketPrice->change_amount) }}"></div>
        <div class="col-md-4"><label class="form-label" for="change_percent">درصد تغییر</label><input class="form-control" id="change_percent" name="change_percent" type="number" step="0.01" value="{{ old('change_percent', $marketPrice->change_percent) }}"></div>
        <div class="col-md-4"><label class="form-label" for="is_active">وضعیت نمایش</label><select class="form-control" id="is_active" name="is_active"><option value="1" @selected((string) old('is_active', (int) $marketPrice->is_active) === '1')>فعال</option><option value="0" @selected((string) old('is_active', (int) $marketPrice->is_active) === '0')>غیرفعال</option></select></div>
        <div class="col-md-4"><label class="form-label" for="sort_order">ترتیب نمایش</label><input class="form-control" id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $marketPrice->sort_order) }}" required></div>
        <div class="col-md-4"><label class="form-label" for="source_name">نام منبع</label><input class="form-control" id="source_name" name="source_name" value="{{ old('source_name', $marketPrice->source_name) }}"></div>
        <div class="col-md-8"><label class="form-label" for="source_url">نشانی منبع</label><input class="form-control" id="source_url" name="source_url" type="url" dir="ltr" value="{{ old('source_url', $marketPrice->source_url) }}"></div>
        <div class="col-md-4"><label class="form-label">آخرین آپدیت</label><input class="form-control" value="{{ optional($marketPrice->fetched_at)->format('Y/m/d H:i') ?? 'ثبت نشده' }}" disabled></div>
    </div>
    <div class="mt-3 d-flex gap-2"><button class="admin-primary-btn" type="submit">ذخیره تغییرات</button><a class="admin-secondary-btn" href="{{ route('admin.market_prices.index') }}">انصراف</a></div>
</form>
@endsection
