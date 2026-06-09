<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1" name="viewport"/>
@php($siteTitle = app(\App\Services\SettingService::class)->get('site.site_title', 'اتاق اصناف مرکز استان گلستان'))
<title>@yield('title', $siteTitle)</title>
<meta content="@yield('meta_description', 'اتاق اصناف مرکز استان گلستان')" name="description"/>
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
