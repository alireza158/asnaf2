@extends('frontend.layouts.app')

@section('title', 'آرشیو نوشته‌ها | اتاق اصناف شهرستان گرگان')
@section('meta_description', 'آرشیو کامل اخبار، اطلاعیه‌ها و نوشته‌های اتاق اصناف شهرستان گرگان')

@section('content')
<div class="page-header">
<div class="site-container">
<nav class="breadcrumb-nav">
<a href="{{ route('home') }}">خانه</a>
<span class="breadcrumb-sep">/</span>
<span>آرشیو نوشته‌ها</span>
</nav>
<h1>آرشیو نوشته‌ها</h1>
</div>
</div>

<main class="archive-page">
<div class="site-container">
<div class="archive-header">
<h1>همه نوشته‌ها</h1>
<div class="archive-filters">
<a class="tab-pill {{ blank($categoryId) ? 'active' : '' }}" href="{{ route('posts.index') }}">همه</a>
@foreach ($categories->take(4) as $category)
<a class="tab-pill {{ (string) $categoryId === (string) $category->id ? 'active' : '' }}" href="{{ route('posts.index', ['category_id' => $category->id]) }}">{{ $category->title }}</a>
@endforeach
</div>
</div>
<div class="archive-grid">
@forelse($posts as $post)
<article class="archive-card">
<a href="{{ route('posts.show', $post->slug) }}">
<img alt="{{ $post->title }}" class="archive-card-img" src="{{ $post->featured_image_url }}" loading="lazy"/>
<div class="archive-card-body">
<span class="card-cat">{{ $post->category_title }} @if($post->type === 'video') 🎥 @elseif($post->galleries_count > 0) 🖼 @endif</span>
<h2>{{ $post->title }}</h2>
<p>{{ $post->short_description ?? Str::limit(strip_tags($post->description), 120) }}</p>
<span class="card-date">{{ jalali_date($post->published_at) ?: jalali_date($post->created_at) }}</span>
</div>
</a>
</article>
@empty
<p class="text-muted">هیچ پست فعالی برای نمایش وجود ندارد.</p>
@endforelse
</div>
<aside class="archive-sidebar">
<div class="sidebar-card">
<h3>جستجو در نوشته‌ها</h3>
<form action="{{ route('posts.index') }}" method="GET">
<input class="search-input" name="search" type="search" value="{{ $search }}" placeholder="جستجوی خبر یا نوشته...">
@if($categoryId)<input type="hidden" name="category_id" value="{{ $categoryId }}">@endif
@if($unionId)<input type="hidden" name="union_id" value="{{ $unionId }}">@endif
<button class="tab-pill active" type="submit">جستجو</button>
</form>
</div>
<div class="sidebar-card">
<h3>دسته‌بندی‌ها</h3>
<ul class="sidebar-list">
<li><a href="{{ route('posts.index') }}">همه نوشته‌ها</a></li>
@foreach ($categories as $category)
<li><a href="{{ route('posts.index', ['category_id' => $category->id]) }}">{{ $category->title }}</a></li>
@endforeach
</ul>
</div>
<div class="sidebar-card">
<h3>اتحادیه‌ها</h3>
<ul class="sidebar-list">
@forelse ($unions->take(8) as $union)
<li><a href="{{ route('posts.index', ['union_id' => $union->id]) }}">{{ $union->display_title }}</a></li>
@empty
<li>اتحادیه‌ای برای فیلتر وجود ندارد.</li>
@endforelse
</ul>
</div>
</aside>
</div>
</main>
@endsection
