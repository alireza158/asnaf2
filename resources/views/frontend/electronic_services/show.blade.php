@extends('frontend.layouts.app')

@section('title', $service->title.' | خدمات الکترونیک')
@section('meta_description', Str::limit($service->short_description ?: strip_tags($service->body), 160))
@section('frontend_variant', 'compact')
@section('footer_links_variant', 'short')

@section('content')
<section class="page-header page-header-alt"><div class="site-container"><h1>{{ $service->title }}</h1><nav class="breadcrumb"><a href="{{ route('home') }}">خانه</a><a href="{{ route('electronic-services.index') }}">خدمات الکترونیک</a><span>{{ $service->title }}</span></nav></div></section>

<section class="site-container">
  <div class="news-single-layout">
    <article class="news-single-main">
      @if ($service->image)<div class="news-single-cover"><img src="{{ Storage::url($service->image) }}" alt="{{ $service->title }}" loading="lazy"/></div>@endif
      <div class="news-single-body">
        <div class="post-meta"><span>🏷 {{ $service->category?->title ?: 'خدمات الکترونیک' }}</span><span>{{ $service->icon ?: '⚡' }}</span></div>
        <h2>{{ $service->title }}</h2>
        @if ($service->short_description)<p class="lead">{{ $service->short_description }}</p>@endif
        <div>{!! $service->body ?: '<p>توضیحات این خدمت هنوز تکمیل نشده است.</p>' !!}</div>
        @if ($service->link_type !== 'none' && $service->link)
          <p class="mt-4"><a class="tab-pill active" href="{{ $service->link }}" target="{{ $service->target }}" @if($service->target === '_blank') rel="noopener" @endif>ورود به خدمت</a></p>
        @endif
      </div>
    </article>
    <aside class="news-sidebar"><div class="news-sidebar-card"><h4>خدمات مرتبط</h4><div class="related-post-list">@forelse ($relatedServices as $related)<a href="{{ route('electronic-services.show', $related->slug) }}" class="related-post-item"><div class="related-post-thumb" style="display:grid;place-items:center;font-size:1.8rem">{{ $related->icon ?: '⚡' }}</div><div><strong>{{ $related->title }}</strong><span>{{ $related->category?->title ?: 'خدمات الکترونیک' }}</span></div></a>@empty<p class="text-muted mb-0">خدمت مرتبطی برای نمایش وجود ندارد.</p>@endforelse</div></div></aside>
  </div>
</section>
@endsection
