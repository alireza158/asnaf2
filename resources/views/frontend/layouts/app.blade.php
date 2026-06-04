@php
    $frontendVariant = trim($__env->yieldContent('frontend_variant', 'classic')) ?: 'classic';
@endphp
<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1" name="viewport"/>
<title>@yield('title', 'اتاق اصناف شهرستان گرگان')</title>
<meta content="@yield('meta_description', '')" name="description"/>
@include('frontend.partials.styles')
</head>
<body>
@include('frontend.partials.header')
@yield('content')
@include('frontend.partials.footer')
@yield('after_footer')
@include('frontend.partials.scripts')
</body>
</html>
