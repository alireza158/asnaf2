@extends('frontend.layouts.app')

@section('title', ($post->meta_title ?: $post->title).' | اتاق اصناف شهرستان گرگان')
@section('meta_description', $post->meta_description ?: $post->excerpt)
@section('meta_keywords', $post->meta_keywords)

@section('content')
<div class="page-header">
    <div class="site-container">
        <nav class="breadcrumb-nav">
            <a href="{{ route('home') }}">خانه</a>
            <span class="breadcrumb-sep">/</span>
            <a href="{{ route('posts.index') }}">آرشیو اخبار</a>
            <span class="breadcrumb-sep">/</span>
            <span>{{ $post->title }}</span>
        </nav>
        <h1>{{ $post->title }}</h1>
    </div>
</div>

<main>
    <div class="site-container single-post-layout">
        <article class="single-post-article">
            <img class="post-featured-img" src="{{ $post->featured_image ? Storage::url($post->featured_image) : asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="{{ $post->title }}">

            <div class="single-post-body">
                <div class="post-meta">
                    <span>تاریخ انتشار: {{ jalali_date($post->published_at) }}</span>
                    <span class="dot"></span>
                    <span>دسته‌بندی: {{ $post->category?->title ?: 'اخبار' }}</span>
                    <span class="dot"></span>
                    <span>بازدید: {{ number_format($post->views_count) }}</span>
                    @if ($post->union)<span class="dot"></span><span>{{ $post->union->name }}</span>@endif
                    @if ($post->is_important)<span class="dot"></span><span>خبر مهم</span>@endif
                </div>

                <h1>{{ $post->title }}</h1>

                @if ($post->excerpt)
                    <div class="post-excerpt">{{ $post->excerpt }}</div>
                @endif

                <div class="post-content">
                    {!! $post->body !!}
                </div>

                @if ($post->galleries->isNotEmpty())
                    <div class="post-gallery" data-gallery-group="post-{{ $post->id }}">
                        <h3>گالری تصاویر</h3>
                        <div class="post-gallery-grid">
                            @foreach ($post->galleries as $gallery)
                                <div class="post-gallery-item" data-gallery-item="{{ Storage::url($gallery->image) }}">
                                    <img src="{{ Storage::url($gallery->image) }}" alt="{{ $gallery->caption ?: $post->title }}" loading="lazy">
                                    @if ($gallery->caption)<small>{{ $gallery->caption }}</small>@endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="post-tags">
                    <span class="post-tag">{{ $post->type }}</span>
                    @if ($post->category)<span class="post-tag">{{ $post->category->title }}</span>@endif
                    @if ($post->union)<span class="post-tag">{{ $post->union->name }}</span>@endif
                </div>
            </div>
        </article>

        <aside class="single-post-sidebar">
            <div class="sidebar-card">
                <h3>اطلاعات خبر</h3>
                <ul class="sidebar-list">
                    <li>نوع محتوا: {{ $post->type }}</li>
                    <li>دسته‌بندی: {{ $post->category?->title ?: 'بدون دسته‌بندی' }}</li>
                    <li>اتحادیه: {{ $post->union?->name ?: 'خبر عمومی' }}</li>
                </ul>
            </div>

            @if ($relatedPosts->isNotEmpty())
                <div class="sidebar-card">
                    <h3>اخبار مرتبط</h3>
                    <ul class="sidebar-list">
                        @foreach ($relatedPosts as $relatedPost)
                            <li><a href="{{ route('posts.show', $relatedPost->slug) }}">{{ $relatedPost->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </aside>
    </div>
</main>
@endsection
