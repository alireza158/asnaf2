<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'پنل مدیریت') | اتاق اصناف شهرستان گرگان</title>
    <link href="https://cdn.jsdelivr.net" rel="preconnect">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vazirmatn@33.003/Vazirmatn-font-face.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/admin.css') }}?v={{ filemtime(public_path('assets/admin/css/admin.css')) }}" rel="stylesheet">
</head>
<body>
    <div class="admin-shell">
        @include('admin.partials.sidebar')

        <div class="admin-main">
            @include('admin.partials.header')

            <main class="admin-content">
                @include('admin.partials.alerts')
                @yield('content')
            </main>

            @include('admin.partials.footer')
        </div>
    </div>

    <div class="admin-backdrop" data-admin-sidebar-close></div>

    <div class="modal fade" id="adminDeleteModal" tabindex="-1" aria-labelledby="adminDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content admin-confirm-modal">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="adminDeleteModalLabel">تایید عملیات حذف</h2>
                    <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="بستن"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-2">این عملیات قابل بازگشت نیست. آیا از حذف این مورد مطمئن هستید؟</p>
                    <small class="text-muted" data-admin-delete-message></small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="admin-secondary-btn" data-bs-dismiss="modal">انصراف</button>
                    <button type="button" class="admin-danger-btn" data-admin-delete-confirm>بله، حذف شود</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/persian-date@1.1.0/dist/persian-date.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="{{ asset('assets/admin/js/admin.js') }}"></script>
    <script>window.adminRichTextUploadUrl = @json(route('admin.rich_text.upload'));</script>
    <script src="{{ asset('assets/admin/js/rich-editor.js') }}"></script>
    @stack('scripts')
</body>
</html>
