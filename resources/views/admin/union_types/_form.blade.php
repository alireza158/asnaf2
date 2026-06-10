<div class="admin-panel-card"><div class="row g-3">
    <div class="col-md-6"><label class="form-label" for="title">عنوان</label><input class="form-control" id="title" name="title" value="{{ old('title', $unionType?->title) }}" required></div>
    <div class="col-md-6"><label class="form-label" for="slug">نامک</label><input class="form-control" id="slug" name="slug" value="{{ old('slug', $unionType?->slug) }}" dir="ltr"></div>
    <div class="col-md-4"><label class="form-label" for="icon">آیکون (emoji یا کلاس)</label><input class="form-control" id="icon" name="icon" value="{{ old('icon', $unionType?->icon) }}" placeholder="🏭 یا fa fa-industry"></div>
    <div class="col-md-4"><label class="form-label" for="sort_order">ترتیب نمایش</label><input class="form-control" id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $unionType?->sort_order ?? 0) }}"></div>
    <div class="col-md-4"><label class="form-label" for="is_active">وضعیت</label><select class="form-control" id="is_active" name="is_active"><option value="1" @selected((string) old('is_active', (int) ($unionType?->is_active ?? true)) === '1')>فعال</option><option value="0" @selected((string) old('is_active', (int) ($unionType?->is_active ?? true)) === '0')>غیرفعال</option></select></div>
</div></div>
<div class="mt-3 d-flex gap-2"><button class="admin-primary-btn">ذخیره نوع اتحادیه</button><a class="admin-secondary-btn" href="{{ route('admin.union-types.index') }}">انصراف</a></div>
