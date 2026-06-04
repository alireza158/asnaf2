@extends('frontend.layouts.app')

@section('title', 'گزارش تصویری از خدمات اتاق اصناف | اتاق اصناف شهرستان گرگان')
@section('meta_description', '')
@section('frontend_variant', 'compact')
@section('footer_links_variant', 'short')

@section('content')
<section class="page-header page-header-alt">
  <div class="site-container">
    <h1>گزارش تصویری از خدمات اتاق اصناف گرگان</h1>
    <nav class="breadcrumb">
      <a href="{{ route('frontend.home') }}">خانه</a>
      <a href="{{ route('frontend.home') }}#multimedia">چندرسانه‌ای</a>
      <span>گزارش تصویری از خدمات اتاق اصناف</span>
    </nav>
  </div>
</section>

<section class="site-container">
  <div class="video-single-layout">
    <div class="video-single-main">
      <div class="video-player-wrap">
        <div class="video-player">
          <img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="ویدیو" loading="lazy"/>
          <div class="video-player-overlay"></div>
          <button class="video-big-play" type="button" aria-label="پخش ویدیو"></button>
        </div>
      </div>
      <div class="video-single-body">
        <div class="video-meta">
          <span>📅 ۲ اردیبهشت ۱۴۰۵</span>
          <span>👁 ۱,۲۵۶ بازدید</span>
          <span>⏱ ۱۲:۳۴ دقیقه</span>
        </div>
        <h2>گزارش تصویری از خدمات اتاق اصناف گرگان به کسبه شهرستان</h2>
        <p>در این ویدیو با بخشی از خدمات اتاق اصناف شهرستان گرگان از جمله صدور و تمدید پروانه کسب، بازرسی از واحدهای صنفی، برگزاری دوره‌های آموزشی و... آشنا خواهید شد. این گزارش تصویری در اردیبهشت ماه ۱۴۰۵ تهیه شده است.</p>
        <p>اتاق اصناف شهرستان گرگان همواره در تلاش است تا با ارائه خدمات مطلوب و به‌روز، رضایت فعالان صنفی و شهروندان گرامی را جلب نماید.</p>
        <div class="video-tags">
          <span class="post-tag">گزارش تصویری</span>
          <span class="post-tag">خدمات صنفی</span>
          <span class="post-tag">اتاق اصناف</span>
          <span class="post-tag">گرگان</span>
        </div>
      </div>
    </div>
    <aside class="video-sidebar">
      <div class="video-sidebar-card">
        <h4>ویدیوهای مرتبط</h4>
        <div class="video-related-list">
          <a href="{{ route('frontend.videos.show', 'sample-video') }}" class="video-related-item">
            <div class="vri-thumb"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="ویدیو مرتبط" loading="lazy"/><span class="vri-play-icon"></span></div>
            <div class="vri-body">
              <strong>راهنمای مراحل صدور و تمدید پروانه کسب</strong>
              <span>۸:۲۱ دقیقه</span>
            </div>
          </a>
          <a href="{{ route('frontend.videos.show', 'sample-video') }}" class="video-related-item">
            <div class="vri-thumb"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="ویدیو مرتبط" loading="lazy"/><span class="vri-play-icon"></span></div>
            <div class="vri-body">
              <strong>گفت‌وگو درباره آموزش احکام تجارت</strong>
              <span>۱۵:۴۰ دقیقه</span>
            </div>
          </a>
          <a href="{{ route('frontend.videos.show', 'sample-video') }}" class="video-related-item">
            <div class="vri-thumb"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="ویدیو مرتبط" loading="lazy"/><span class="vri-play-icon"></span></div>
            <div class="vri-body">
              <strong>بازدید میدانی بازرسان از واحدهای صنفی گرگان</strong>
              <span>۱۰:۱۲ دقیقه</span>
            </div>
          </a>
          <a href="{{ route('frontend.videos.show', 'sample-video') }}" class="video-related-item">
            <div class="vri-thumb"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="ویدیو مرتبط" loading="lazy"/><span class="vri-play-icon"></span></div>
            <div class="vri-body">
              <strong>نشست هماهنگی اتحادیه‌های صنفی شهرستان</strong>
              <span>۲۲:۰۵ دقیقه</span>
            </div>
          </a>
          <a href="{{ route('frontend.videos.show', 'sample-video') }}" class="video-related-item">
            <div class="vri-thumb"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="ویدیو مرتبط" loading="lazy"/><span class="vri-play-icon"></span></div>
            <div class="vri-body">
              <strong>معرفی سامانه‌های الکترونیکی اصناف</strong>
              <span>۶:۵۸ دقیقه</span>
            </div>
          </a>
        </div>
      </div>
    </aside>
  </div>
</section>
@endsection
