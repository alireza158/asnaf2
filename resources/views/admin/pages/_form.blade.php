<div class="row g-3">
    <div class="col-md-8"><label class="form-label" for="title">عنوان</label><input class="form-control" id="title" name="title" value="{{ old('title', $page?->title) }}" required></div>
    <div class="col-md-4"><label class="form-label" for="slug">اسلاگ</label><input class="form-control" dir="ltr" id="slug" name="slug" value="{{ old('slug', $page?->slug) }}" required></div>
    <div class="col-12"><label class="form-label" for="excerpt">خلاصه</label><textarea class="form-control" id="excerpt" name="excerpt" rows="2">{{ old('excerpt', $page?->excerpt) }}</textarea></div>
    <div class="col-12"><label class="form-label" for="body">محتوای صفحه</label><textarea class="form-control js-rich-editor" id="body" name="body" rows="12">{{ old('body', $page?->body) }}</textarea></div>
    <div class="col-md-4"><label class="form-label" for="featured_image">تصویر شاخص</label><input class="form-control" id="featured_image" name="featured_image" type="file" accept="image/*">@if($page?->featured_image)<small><a href="{{ asset('storage/'.$page->featured_image) }}" target="_blank">مشاهده تصویر فعلی</a></small>@endif</div>
    <div class="col-md-4"><label class="form-label" for="template">قالب</label><select class="form-control" id="template" name="template">@foreach($templates as $template)<option value="{{ $template }}" @selected(old('template', $page?->template ?? 'default') === $template)>{{ $template }}</option>@endforeach</select></div>
    <div class="col-md-4"><label class="form-label" for="status">وضعیت</label><select class="form-control" id="status" name="status">@foreach($statuses as $status)<option value="{{ $status }}" @selected(old('status', $page?->status ?? 'draft') === $status)>{{ $status }}</option>@endforeach</select></div>
    <div class="col-md-4"><label class="form-label" for="published_at">تاریخ انتشار</label><input class="form-control js-jalali-datetime" dir="ltr" id="published_at" name="published_at" type="text" value="{{ old('published_at', jalali_form_datetime($page?->published_at)) }}"></div>
    <div class="col-md-4"><label class="form-label" for="sort_order">ترتیب</label><input class="form-control" dir="ltr" id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $page?->sort_order ?? 0) }}"></div>
    <div class="col-md-4"><label class="form-label" for="is_active">فعال/غیرفعال</label><select class="form-control" id="is_active" name="is_active"><option value="1" @selected((string) old('is_active', $page?->is_active ?? 1) === '1')>فعال</option><option value="0" @selected((string) old('is_active', $page?->is_active ?? 1) === '0')>غیرفعال</option></select></div>
    <div class="col-md-6"><label class="form-label" for="meta_title">Meta Title</label><input class="form-control" id="meta_title" name="meta_title" value="{{ old('meta_title', $page?->meta_title) }}"></div>
    <div class="col-md-6"><label class="form-label" for="meta_keywords">Meta Keywords</label><input class="form-control" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $page?->meta_keywords) }}"></div>
    <div class="col-12"><label class="form-label" for="meta_description">Meta Description</label><textarea class="form-control" id="meta_description" name="meta_description" rows="2">{{ old('meta_description', $page?->meta_description) }}</textarea></div>
    <div class="col-12"><label class="form-label" for="rejected_reason">دلیل رد</label><textarea class="form-control" id="rejected_reason" name="rejected_reason" rows="2">{{ old('rejected_reason', $page?->rejected_reason) }}</textarea></div>
</div>
<div class="admin-form-actions"><button class="admin-primary-btn" type="submit">ذخیره صفحه</button><a class="admin-secondary-btn" href="{{ route('admin.pages.index') }}">انصراف</a></div>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>document.querySelectorAll('.js-rich-editor').forEach((el) => ClassicEditor.create(el, {language: 'fa'}).catch(console.error));</script>
@endpush
