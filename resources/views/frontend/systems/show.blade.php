@extends('frontend.layouts.app')

@section('title', $system->title.' | سامانه‌ها')
@section('meta_description', Str::limit($system->short_description ?: strip_tags($system->description), 160))
@section('frontend_variant', 'compact')
@section('footer_links_variant', 'short')

@section('content')
<section class="page-header page-header-alt">
  <div class="site-container">
    <h1>{{ $system->title }}</h1>
    <nav class="breadcrumb">
      <a href="{{ route('home') }}">خانه</a>
      <a href="{{ route('systems.index') }}">سامانه‌ها</a>
      <span>{{ $system->title }}</span>
    </nav>
  </div>
</section>

<section class="site-container">
  <div class="news-single-layout">
    <article class="news-single-main">
      @if ($system->image)
        <div class="news-single-cover"><img src="{{ Storage::url($system->image) }}" alt="{{ $system->title }}" loading="lazy"/></div>
      @endif
      <div class="news-single-body">
        <div class="post-meta"><span>🏷 {{ $system->category?->title ?: 'سامانه' }}</span><span>{{ $system->icon ?: '💻' }}</span></div>
        <h2>{{ $system->title }}</h2>
        @if ($system->short_description)<p class="lead">{{ $system->short_description }}</p>@endif
        <p>{!! nl2br(e($system->description ?: 'توضیحات این سامانه هنوز تکمیل نشده است.')) !!}</p>
        @if ($system->link)
          <p class="mt-4"><a class="tab-pill active" href="{{ $system->link }}" target="{{ $system->target }}" @if($system->target === '_blank') rel="noopener" @endif>ورود به سامانه</a></p>
        @endif
      </div>
    </article>

    <aside class="news-sidebar">
      <div class="news-sidebar-card">
        <h4>سامانه‌های مرتبط</h4>
        <div class="related-post-list">
          @forelse ($relatedSystems as $related)
            <a href="{{ route('systems.show', $related->slug) }}" class="related-post-item">
              <div class="related-post-thumb" style="display:grid;place-items:center;font-size:1.8rem">{{ $related->icon ?: '💻' }}</div>
              <div><strong>{{ $related->title }}</strong><span>{{ $related->category?->title ?: 'سامانه' }}</span></div>
            </a>
          @empty
            <p class="text-muted mb-0">سامانه مرتبطی برای نمایش وجود ندارد.</p>
          @endforelse
        </div>
      </div>
    </aside>
  </div>
</section>
@endsection
