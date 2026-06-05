@extends('frontend.layouts.app')

@section('title', $post->title.' | اتاق اصناف شهرستان گرگان')
@section('meta_description', Str::limit($post->short_description ?? strip_tags($post->description), 160))

@section('content')
<div class="page-header">
<div class="site-container">
<nav class="breadcrumb-nav">
<a href="{{ route('home') }}">خانه</a>
<span class="breadcrumb-sep">/</span>
<a href="{{ route('posts.index') }}">اخبار</a>
<span class="breadcrumb-sep">/</span>
<span>{{ $post->title }}</span>
</nav>
<h1>{{ $post->title }}</h1>
</div>
</div>

<main>
<div class="site-container single-post-layout">
<article class="single-post-article">
<img alt="{{ $post->title }}" class="post-featured-img" src="{{ $post->featured_image_url }}" loading="lazy"/>
<div class="single-post-body">
<div class="post-meta">
<span>تاریخ انتشار: {{ jalali_date($post->published_at) ?: jalali_date($post->created_at) }}</span>
<span class="dot"></span>
<span>دسته‌بندی: {{ $post->category_title }}</span>
<span class="dot"></span>
<span>بازدید: {{ $post->views_count }}</span>
@if($post->type === 'video')
<span class="dot"></span>
<span>🎥 ویدیویی</span>
@elseif($post->galleries_count > 0)
<span class="dot"></span>
<span>🖼 دارای گالری</span>
@endif
</div>
<h1>{{ $post->title }}</h1>
@if($post->short_description)
<div class="post-excerpt">
{{ $post->short_description }}
</div>
@endif
<div class="post-content">
{!! $post->body ?: '<p>محتوایی برای این نوشته ثبت نشده است.</p>' !!}
</div>
@if($post->galleries->isNotEmpty())
<div class="post-gallery" data-gallery-group="post-{{ $post->id }}">
<h3>گالری تصاویر</h3>
<div class="post-gallery-grid">
@foreach($post->galleries as $image)
<div class="post-gallery-item" data-gallery-item="{{ $image->image_url }}"><img src="{{ $image->image_url }}" alt="{{ $image->caption ?? $post->title }}" loading="lazy"/></div>
@endforeach
</div>
</div>
@endif
<div class="post-tags">
<span class="post-tag">{{ $post->category_title }}</span>
@if($post->union)<span class="post-tag">{{ $post->union->display_title }}</span>@endif
<span class="post-tag">{{ $post->type === 'video' ? 'ویدیو' : 'نوشته' }}</span>
</div>
<div class="post-nav">
@if($previousPost)
<a class="post-nav-link post-nav-prev" href="{{ route('posts.show', $previousPost->slug) }}">
<span>→ نوشته قبلی</span>
<strong>{{ $previousPost->title }}</strong>
</a>
@else
<span class="post-nav-link post-nav-prev"><span>→ نوشته قبلی</span><strong>وجود ندارد</strong></span>
@endif
@if($nextPost)
<a class="post-nav-link post-nav-next" href="{{ route('posts.show', $nextPost->slug) }}">
<span>نوشته بعدی ←</span>
<strong>{{ $nextPost->title }}</strong>
</a>
@else
<span class="post-nav-link post-nav-next"><span>نوشته بعدی ←</span><strong>وجود ندارد</strong></span>
@endif
</div>
</div>
</article>
<aside class="single-post-sidebar">
<div class="sidebar-card">
<h3>آخرین نوشته‌ها</h3>
<ul class="sidebar-list">
@forelse($relatedPosts as $relatedPost)
<li><a href="{{ route('posts.show', $relatedPost->slug) }}">{{ $relatedPost->title }}</a></li>
@empty
<li>نوشته مرتبطی برای نمایش وجود ندارد.</li>
@endforelse
</ul>
</div>
<div class="sidebar-card">
<h3>دسته‌بندی</h3>
<ul class="sidebar-list">
<li><a href="{{ $post->category ? route('posts.index', ['category_id' => $post->category->id]) : route('posts.index') }}">{{ $post->category_title }}</a></li>
@if($post->union)<li><a href="{{ route('posts.index', ['union_id' => $post->union->id]) }}">{{ $post->union->display_title }}</a></li>@endif
</ul>
</div>
<div class="sidebar-card">
<h3>برچسب‌ها</h3>
<div class="post-tags">
<span class="post-tag">اصناف</span>
<span class="post-tag">گرگان</span>
<span class="post-tag">{{ $post->category_title }}</span>
@if($post->type === 'video')<span class="post-tag">ویدیو</span>@endif
</div>
</div>
</aside>
</div>
</main>
@endsection

@section('after_footer')
<div class="lightbox">
  <button class="lightbox-close" aria-label="بستن">✕</button>
  <button class="lightbox-nav lightbox-prev" aria-label="قبلی">‹</button>
  <button class="lightbox-nav lightbox-next" aria-label="بعدی">›</button>
  <img class="lightbox-img" src="" alt="تصویر بزرگ"/>
  <div class="lightbox-counter"></div>
</div>
@endsection
