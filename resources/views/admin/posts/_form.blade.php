@php
    $selectedStatus = old('status', $post?->status ?? 'draft');
    $selectedType = old('type', $post?->type ?? 'news');
@endphp

<div class="admin-panel-card">
    <div class="row g-3">
        <div class="col-md-8">
            <label class="form-label" for="title">عنوان خبر</label>
            <input class="form-control" id="title" name="title" value="{{ old('title', $post?->title) }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label" for="slug">اسلاگ</label>
            <input class="form-control" id="slug" name="slug" value="{{ old('slug', $post?->slug) }}" dir="ltr" required>
        </div>
        <div class="col-md-4">
            <label class="form-label" for="category_id">دسته‌بندی</label>
            <select class="form-control" id="category_id" name="category_id">
                <option value="">بدون دسته‌بندی</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) old('category_id', $post?->category_id) === (string) $category->id)>{{ $category->title }}</option>
                @endforeach
            </select>
            <small class="text-muted">دسته‌بندی‌ها از جدول post_categories خوانده می‌شوند.</small>
        </div>
        <div class="col-md-4">
            <label class="form-label" for="union_id">اتحادیه مرتبط</label>
            <select class="form-control" id="union_id" name="union_id">
                <option value="">خبر عمومی / بدون اتحادیه</option>
                @foreach ($unions as $union)
                    <option value="{{ $union->id }}" @selected((string) old('union_id', $post?->union_id) === (string) $union->id)>{{ $union->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label" for="type">نوع محتوا</label>
            <select class="form-control" id="type" name="type" required>
                @foreach ($types as $type)
                    <option value="{{ $type }}" @selected($selectedType === $type)>{{ $type }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="status">وضعیت</label>
            <select class="form-control" id="status" name="status" required>
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" @selected($selectedStatus === $status)>{{ $status }}</option>
                @endforeach
            </select>
            <small class="text-muted">کاربران محتواگذار فقط می‌توانند draft یا pending انتخاب کنند.</small>
        </div>
        <div class="col-md-3">
            <label class="form-label" for="published_at">تاریخ انتشار</label>
            <input class="form-control js-jalali-datetime" id="published_at" name="published_at" type="text" dir="ltr" value="{{ old('published_at', jalali_form_datetime($post?->published_at)) }}">
        </div>
        <div class="col-md-3">
            <label class="form-label" for="sort_order">ترتیب نمایش</label>
            <input class="form-control" id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $post?->sort_order ?? 0) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label" for="is_important">خبر مهم</label>
            <select class="form-control" id="is_important" name="is_important">
                <option value="1" @selected((string) old('is_important', (int) ($post?->is_important ?? false)) === '1')>بله</option>
                <option value="0" @selected((string) old('is_important', (int) ($post?->is_important ?? false)) === '0')>خیر</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label" for="is_featured">ویژه</label>
            <select class="form-control" id="is_featured" name="is_featured">
                <option value="1" @selected((string) old('is_featured', (int) ($post?->is_featured ?? false)) === '1')>بله</option>
                <option value="0" @selected((string) old('is_featured', (int) ($post?->is_featured ?? false)) === '0')>خیر</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label" for="is_active">فعال</label>
            <select class="form-control" id="is_active" name="is_active">
                <option value="1" @selected((string) old('is_active', (int) ($post?->is_active ?? true)) === '1')>فعال</option>
                <option value="0" @selected((string) old('is_active', (int) ($post?->is_active ?? true)) === '0')>غیرفعال</option>
            </select>
        </div>
        <div class="col-12">
            <label class="form-label" for="excerpt">خلاصه خبر</label>
            <textarea class="form-control" id="excerpt" name="excerpt" rows="3">{{ old('excerpt', $post?->excerpt) }}</textarea>
        </div>
        <div class="col-12">
            <label class="form-label" for="body">متن کامل خبر</label>
            <textarea class="form-control js-rich-editor" id="body" name="body" rows="12">{{ old('body', $post?->body) }}</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="featured_image">تصویر شاخص</label>
            <input class="form-control" id="featured_image" name="featured_image" type="file" accept="image/*">
            @if ($post?->featured_image)
                <a class="d-inline-block mt-2" href="{{ Storage::url($post->featured_image) }}" target="_blank">مشاهده تصویر فعلی</a>
            @endif
        </div>
        <div class="col-md-6">
            <label class="form-label" for="gallery_images">گالری تصاویر</label>
            <input class="form-control" id="gallery_images" name="gallery_images[]" type="file" accept="image/*" multiple>
            <div id="galleryCaptionFields" class="mt-2">
                <input class="form-control mb-2" name="gallery_captions[]" placeholder="کپشن تصویر ۱ (اختیاری)">
            </div>
            <small class="text-muted">برای هر تصویر انتخاب‌شده یک فیلد کپشن ساخته می‌شود.</small>
        </div>
        @if ($post?->galleries?->isNotEmpty())
            <div class="col-12">
                <label class="form-label">تصاویر فعلی گالری</label>
                <div class="row g-3">
                    @foreach ($post->galleries as $gallery)
                        <div class="col-md-3">
                            <div class="border rounded p-2 h-100">
                                <img src="{{ Storage::url($gallery->image) }}" alt="{{ $gallery->caption }}" class="img-fluid rounded mb-2">
                                <p class="small mb-2">{{ $gallery->caption ?: 'بدون کپشن' }}</p>
                                <label class="small"><input type="checkbox" name="delete_gallery[]" value="{{ $gallery->id }}"> حذف این تصویر</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        <div class="col-12">
            <label class="form-label" for="rejected_reason">دلیل رد خبر</label>
            <textarea class="form-control" id="rejected_reason" name="rejected_reason" rows="3">{{ old('rejected_reason', $post?->rejected_reason) }}</textarea>
        </div>
        <div class="col-md-4">
            <label class="form-label" for="meta_title">عنوان متا</label>
            <input class="form-control" id="meta_title" name="meta_title" value="{{ old('meta_title', $post?->meta_title) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label" for="meta_description">توضیحات متا</label>
            <input class="form-control" id="meta_description" name="meta_description" value="{{ old('meta_description', $post?->meta_description) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label" for="meta_keywords">کلیدواژه‌های متا</label>
            <input class="form-control" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $post?->meta_keywords) }}">
        </div>
    </div>
</div>

<div class="mt-3 d-flex gap-2">
    <button class="admin-primary-btn" type="submit">ذخیره خبر</button>
    <a class="admin-secondary-btn" href="{{ route('admin.posts.index') }}">انصراف</a>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
document.querySelectorAll('.js-rich-editor').forEach((el) => ClassicEditor.create(el, {language: 'fa'}).catch(console.error));
const galleryInput = document.getElementById('gallery_images');
const galleryCaptionFields = document.getElementById('galleryCaptionFields');
galleryInput?.addEventListener('change', () => {
    galleryCaptionFields.innerHTML = '';
    Array.from(galleryInput.files).forEach((file, index) => {
        const input = document.createElement('input');
        input.className = 'form-control mb-2';
        input.name = 'gallery_captions[]';
        input.placeholder = `کپشن تصویر ${index + 1}: ${file.name}`;
        galleryCaptionFields.appendChild(input);
    });
});
</script>
@endpush
