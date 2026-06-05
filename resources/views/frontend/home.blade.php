@extends('frontend.layouts.app')

@section('title', 'اتاق اصناف شهرستان گرگان')
@section('meta_description', 'صفحه اصلی اتاق اصناف شهرستان گرگان؛ دسترسی به اخبار، اطلاعیه‌ها، اتحادیه‌ها، خدمات الکترونیک و راه‌های ارتباطی.')
@section('active_menu', 'home')

@section('content')
<main>
    @foreach ($sections as $section)
        @includeIf('frontend.home.sections.'.$section->key, ['section' => $section])
    @endforeach
</main>
@endsection
