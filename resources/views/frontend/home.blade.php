@extends('frontend.layouts.app')

@section('title', 'اتاق اصناف شهرستان گرگان')
@section('meta_description', 'صفحه اصلی اتاق اصناف شهرستان گرگان؛ دسترسی به اخبار، اطلاعیه‌ها، اتحادیه‌ها، خدمات الکترونیک و راه‌های ارتباطی.')
@section('active_menu', 'home')

@section('content')
<main>
    @forelse ($sections as $section)
        @includeIf('frontend.home.sections.'.$section->key, ['section' => $section])
    @empty
        @include('frontend.home.sections.hero_slider', ['section' => new \App\Models\HomeSection(['title' => 'اتاق اصناف شهرستان گرگان'])])
        @include('frontend.home.sections.electronic_services', ['section' => new \App\Models\HomeSection(['title' => 'خدمات الکترونیک صنفی'])])
    @endforelse
</main>
@endsection
