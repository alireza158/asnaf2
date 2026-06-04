@extends('frontend.layouts.app')

@section('title', 'جلسه هیئت رئیسه اردیبهشت ۱۴۰۵ | اتاق اصناف شهرستان گرگان')
@section('meta_description', '')
@section('frontend_variant', 'compact')
@section('compact_show_tourism_nav', 'false')
@section('footer_links_variant', 'gallery-detail')

@section('content')
<section class="page-header page-header-alt">
  <div class="site-container">
    <h1>جلسه هیئت رئیسه اردیبهشت ۱۴۰۵</h1>
    <nav class="breadcrumb">
      <a href="{{ route('frontend.home') }}">خانه</a>
      <a href="{{ route('frontend.galleries.index') }}">گالری</a>
      <span>جلسه هیئت رئیسه اردیبهشت ۱۴۰۵</span>
    </nav>
  </div>
</section>

<section class="site-container">
  <div class="gallery-single-layout">

    <div class="gallery-single-main">
      <p class="gallery-desc">تصاویر جلسه ماهانه هیئت رئیسه اتاق اصناف شهرستان گرگان که در تاریخ ۲ اردیبهشت ۱۴۰۵ در سالن جلسات ساختمان اتاق اصناف برگزار شد. در این جلسه مباحث مربوط به صدور و تمدید پروانه‌های کسب، بررسی شکایات صنفی و برنامه‌های آموزشی سال جاری مطرح گردید.</p>

      <div class="gallery-thumbs" data-gallery-group="g1">
        <div class="gallery-thumb" data-gallery-item="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="تصویر ۱" loading="lazy"/></div>
        <div class="gallery-thumb" data-gallery-item="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="تصویر ۲" loading="lazy"/></div>
        <div class="gallery-thumb" data-gallery-item="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="تصویر ۳" loading="lazy"/></div>
        <div class="gallery-thumb" data-gallery-item="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="تصویر ۴" loading="lazy"/></div>
        <div class="gallery-thumb" data-gallery-item="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="تصویر ۵" loading="lazy"/></div>
        <div class="gallery-thumb" data-gallery-item="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="تصویر ۶" loading="lazy"/></div>
        <div class="gallery-thumb" data-gallery-item="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="تصویر ۷" loading="lazy"/></div>
        <div class="gallery-thumb" data-gallery-item="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="تصویر ۸" loading="lazy"/></div>
        <div class="gallery-thumb" data-gallery-item="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="تصویر ۹" loading="lazy"/></div>
        <div class="gallery-thumb" data-gallery-item="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="تصویر ۱۰" loading="lazy"/></div>
        <div class="gallery-thumb" data-gallery-item="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="تصویر ۱۱" loading="lazy"/></div>
        <div class="gallery-thumb" data-gallery-item="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="تصویر ۱۲" loading="lazy"/></div>
      </div>
    </div>

    <aside class="gallery-sidebar">
      <div class="gallery-sidebar-card">
        <h4>سایر گالری‌ها</h4>
        <ul class="gallery-sidebar-list">
          <li><a href="{{ route('frontend.galleries.show', 'sample-gallery') }}">نمایشگاه صنایع دستی گرگان</a></li>
          <li><a href="{{ route('frontend.galleries.show', 'sample-gallery') }}">دوره آموزشی قوانین کسب‌وکار</a></li>
          <li><a href="{{ route('frontend.galleries.show', 'sample-gallery') }}">افتتاح ساختمان جدید اتحادیه</a></li>
          <li><a href="{{ route('frontend.galleries.show', 'sample-gallery') }}">گزارش تصویری هفته اصناف</a></li>
          <li><a href="{{ route('frontend.galleries.show', 'sample-gallery') }}">بازدید از واحدهای صنفی</a></li>
          <li><a href="{{ route('frontend.galleries.show', 'sample-gallery') }}">همایش اقتصاد مقاومتی</a></li>
        </ul>
      </div>
      <div class="gallery-sidebar-card">
        <h4>آمار گالری</h4>
        <ul class="gallery-sidebar-list">
          <li>تعداد تصاویر: ۱۲</li>
          <li>تاریخ انتشار: ۲ اردیبهشت ۱۴۰۵</li>
          <li>آخرین بروزرسانی: ۲ اردیبهشت ۱۴۰۵</li>
        </ul>
      </div>
    </aside>

  </div>
</section>
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
