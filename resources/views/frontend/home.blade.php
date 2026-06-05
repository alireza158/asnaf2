@extends('frontend.layouts.app')

@section('title', 'اتاق اصناف شهرستان گرگان')
@section('meta_description', 'آخرین اخبار، اطلاعیه‌ها، خدمات، اتحادیه‌ها و جاذبه‌های گردشگری اتاق اصناف شهرستان گرگان.')

@section('content')
<main>
    @foreach ($sections as $section)
        @includeIf('frontend.home.sections.'.$section->key, ['section' => $section])
    @endforeach
</main>
@endsection
