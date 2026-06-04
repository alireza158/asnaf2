@extends('frontend.layouts.app')

@section('title', 'گالری تصاویر و ویدیوها | اتاق اصناف شهرستان گرگان')
@section('meta_description', '')
@section('frontend_variant', 'compact')
@section('compact_show_tourism_nav', 'false')
@section('footer_links_variant', 'full')

@section('content')
<section class="page-header page-header-alt">
  <div class="site-container">
    <h1>گالری تصاویر و ویدیوها</h1>
    <nav class="breadcrumb">
      <a href="{{ route('home') }}">خانه</a>
      <span>گالری</span>
    </nav>
  </div>
</section>

<section class="site-container">
  <div class="section-heading section-heading-centered">
    <h2>دسته‌بندی گالری‌ها</h2>
    <p>مجموعه تصاویر و ویدیوهای رویدادها، جلسات و فعالیت‌های اتاق اصناف</p>
  </div>
  <div class="gallery-albums-grid">
    <a href="{{ route('galleries.show', 'sample-gallery') }}" class="gallery-album-card">
      <img class="gallery-album-img" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="جلسه هیئت رئیسه اتاق اصناف" loading="lazy"/>
      <div class="gallery-album-body">
        <h3>جلسه هیئت رئیسه اردیبهشت ۱۴۰۵</h3>
        <p>تصاویر جلسه ماهانه هیئت رئیسه اتاق اصناف شهرستان گرگان با حضور اعضای محترم</p>
        <div class="gallery-album-meta">
          <span>۱۲ تصویر</span>
          <span>۲ اردیبهشت ۱۴۰۵</span>
        </div>
      </div>
    </a>
    <a href="{{ route('galleries.show', 'sample-gallery') }}" class="gallery-album-card">
      <img class="gallery-album-img" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="نمایشگاه صنایع دستی" loading="lazy"/>
      <div class="gallery-album-body">
        <h3>نمایشگاه صنایع دستی گرگان</h3>
        <p>بازدید رئیس اتاق اصناف از غرفه‌های نمایشگاه صنایع دستی و هنرهای سنتی</p>
        <div class="gallery-album-meta">
          <span>۲۴ تصویر</span>
          <span>۲۸ فروردین ۱۴۰۵</span>
        </div>
      </div>
    </a>
    <a href="{{ route('galleries.show', 'sample-gallery') }}" class="gallery-album-card">
      <img class="gallery-album-img" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="دوره آموزشی اصناف" loading="lazy"/>
      <div class="gallery-album-body">
        <h3>دوره آموزشی قوانین کسب‌وکار</h3>
        <p>دوره آموزشی یک روزه با حضور صنوف مختلف شهرستان گرگان در سالن اجتماعات اتاق اصناف</p>
        <div class="gallery-album-meta">
          <span>۱۸ تصویر</span>
          <span>۱۵ فروردین ۱۴۰۵</span>
        </div>
      </div>
    </a>
    <a href="{{ route('galleries.show', 'sample-gallery') }}" class="gallery-album-card">
      <img class="gallery-album-img" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="افتتاح پروژه عمرانی" loading="lazy"/>
      <div class="gallery-album-body">
        <h3>افتتاح ساختمان جدید اتحادیه</h3>
        <p>مراسم افتتاح ساختمان جدید اتحادیه صنف فروشندگان مصالح ساختمانی گرگان</p>
        <div class="gallery-album-meta">
          <span>۳۰ تصویر</span>
          <span>۱۰ اسفند ۱۴۰۴</span>
        </div>
      </div>
    </a>
    <a href="{{ route('galleries.show', 'sample-gallery') }}" class="gallery-album-card gallery-album-video">
      <img class="gallery-album-img" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="گزارش تصویری" loading="lazy"/>
      <div class="gallery-album-body">
        <h3>گزارش تصویری هفته اصناف</h3>
        <p>مجموعه ویدیوهای کوتاه از مراسم بزرگداشت هفته اصناف و تقدیر از فعالان صنفی</p>
        <div class="gallery-album-meta">
          <span>۵ ویدیو</span>
          <span>۱۲ بهمن ۱۴۰۴</span>
        </div>
      </div>
    </a>
    <a href="{{ route('galleries.show', 'sample-gallery') }}" class="gallery-album-card">
      <img class="gallery-album-img" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="بازدید میدانی" loading="lazy"/>
      <div class="gallery-album-body">
        <h3>بازدید از واحدهای صنفی شهرستان</h3>
        <p>تصاویر بازدید سرزده کارشناسان اتاق اصناف از واحدهای صنفی سطح شهر</p>
        <div class="gallery-album-meta">
          <span>۲۲ تصویر</span>
          <span>۳ دی ۱۴۰۴</span>
        </div>
      </div>
    </a>
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
