<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'پنل مدیریت') | اتاق اصناف شهرستان گرگان</title>
    <link href="https://cdn.jsdelivr.net" rel="preconnect">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/admin.css') }}" rel="stylesheet">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/admin/js/admin.js') }}"></script>
</body>
</html>
