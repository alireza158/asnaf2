@extends('frontend.layouts.app')

@section('title', $video->title.' | اتاق اصناف شهرستان گرگان')
@section('meta_description', Str::limit(strip_tags($video->description), 160))
@section('frontend_variant', 'compact')
@section('footer_links_variant', 'short')

@section('content')
<section class="page-header page-header-alt">
  <div class="site-container">
    <h1>{{ $video->title }}</h1>
    <nav class="breadcrumb">
      <a href="{{ route('home') }}">خانه</a>
      <a href="{{ route('videos.index') }}">ویدیوها</a>
      <span>{{ $video->title }}</span>
    </nav>
  </div>
</section>

<section class="site-container">
  <div class="video-single-layout">
    <div class="video-single-main">
      <div class="video-player-wrap">
        <div class="video-player">
          @if ($video->video_type === 'upload' && $video->video_file)
            <video controls playsinline poster="{{ $video->cover_image ? Storage::url($video->cover_image) : asset('assets/img/asnaf-gorgan-default.jpg') }}" style="width:100%;height:100%;object-fit:contain;background:#000">
              <source src="{{ Storage::url($video->video_file) }}">
              مرورگر شما از نمایش ویدیو پشتیبانی نمی‌کند.
            </video>
          @elseif ($video->video_type === 'aparat' && $video->aparat_url)
            <iframe src="{{ $video->aparat_embed_url }}" title="{{ $video->title }}" allowfullscreen style="width:100%;height:100%;border:0"></iframe>
          @else
            <img src="{{ $video->cover_image ? Storage::url($video->cover_image) : asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="{{ $video->title }}" loading="lazy"/>
            <div class="video-player-overlay"></div>
          @endif
        </div>
      </div>
      <div class="video-single-body">
        <div class="video-meta">
          <span>📅 {{ $video->published_at?->format('Y/m/d') ?: $video->created_at?->format('Y/m/d') }}</span>
          <span>🏢 {{ $video->union?->display_title ?: 'عمومی' }}</span>
          <span>🎬 {{ $video->type_label }}</span>
        </div>
        <h2>{{ $video->title }}</h2>
        <p>{{ $video->description ?: 'توضیحاتی برای این ویدیو ثبت نشده است.' }}</p>
        <div class="video-tags">
          <span class="post-tag">ویدیو</span>
          <span class="post-tag">{{ $video->type_label }}</span>
          @if ($video->union)<span class="post-tag">{{ $video->union->display_title }}</span>@endif
        </div>
        @if ($video->video_type === 'aparat')
          <p class="mt-3"><a class="post-tag" href="{{ $video->aparat_url }}" target="_blank">مشاهده در آپارات</a></p>
        @endif
      </div>
    </div>
    <aside class="video-sidebar">
      <div class="video-sidebar-card">
        <h4>ویدیوهای مرتبط</h4>
        <div class="video-related-list">
          @forelse ($relatedVideos as $related)
            <a href="{{ route('videos.show', $related->slug) }}" class="video-related-item">
              <div class="vri-thumb"><img src="{{ $related->cover_image ? Storage::url($related->cover_image) : asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="{{ $related->title }}" loading="lazy"/><span class="vri-play-icon"></span></div>
              <div class="vri-body"><strong>{{ $related->title }}</strong><span>{{ $related->type_label }}</span></div>
            </a>
          @empty
            <p class="text-muted mb-0">ویدیوی مرتبطی برای نمایش وجود ندارد.</p>
          @endforelse
        </div>
      </div>
    </aside>
  </div>
</section>
@endsection
