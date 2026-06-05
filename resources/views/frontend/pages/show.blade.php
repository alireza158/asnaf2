@extends('frontend.layouts.app')

@section('title', $page->meta_title ?: $page->title.' | اتاق اصناف شهرستان گرگان')
@section('meta_description', $page->meta_description ?: $page->excerpt)

@section('content')
<div class="page-header">
    <div class="site-container">
        <nav class="breadcrumb-nav">
            <a href="{{ route('home') }}">خانه</a>
            <span class="breadcrumb-sep">/</span>
            <span>{{ $page->title }}</span>
        </nav>
        <h1>{{ $page->title }}</h1>
    </div>
</div>

<main class="blank-page">
    <div class="site-container blank-page-content">
        @if ($page->featured_image)
            <p><img class="post-featured-img" src="{{ Storage::url($page->featured_image) }}" alt="{{ $page->title }}" loading="lazy"></p>
        @endif

        @if ($page->excerpt)
            <p class="lead">{{ $page->excerpt }}</p>
        @endif

        {!! $page->body ?: '<p>محتوای این صفحه به‌زودی تکمیل می‌شود.</p>' !!}
    </div>
</main>
@endsection
