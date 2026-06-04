@extends('frontend.layouts.app')

@section('title', $page->meta_title ?: $page->title.' | اتاق اصناف شهرستان گرگان')
@section('meta_description', $page->meta_description ?: $page->excerpt)

@section('content')
<section class="page-header">
    <div class="site-container">
        <nav class="breadcrumb-nav">
            <a href="{{ route('home') }}">خانه</a>
            <span class="breadcrumb-sep">/</span>
            <span>{{ $page->title }}</span>
        </nav>
        <h1>{{ $page->title }}</h1>
        @if ($page->excerpt)
            <p>{{ $page->excerpt }}</p>
        @endif
    </div>
</section>

<main class="site-container single-layout">
    <article class="single-main">
        @if ($page->featured_image)
            <img class="single-featured-img" src="{{ asset('storage/'.$page->featured_image) }}" alt="{{ $page->title }}" loading="lazy">
        @endif
        <div class="single-content">
            {!! $page->body !!}
        </div>
    </article>
</main>
@endsection
