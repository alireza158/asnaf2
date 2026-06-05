@extends('frontend.layouts.app')

@section('title', 'گردشگری گرگان | اتاق اصناف شهرستان گرگان')
@section('meta_description', '')

@section('content')
<section class="page-header page-header-alt page-header-tourism">
  <div class="site-container">
    <h1>گردشگری در گرگان</h1>
    <nav class="breadcrumb">
      <a href="index.html">خانه</a>
      <span>گردشگری گرگان</span>
    </nav>
  </div>
</section>

<section class="tourism-intro">
  <div class="site-container">
    <div class="tourism-intro-grid">
      <div class="tourism-intro-text">
        <h2>به شهر گرگان خوش آمدید</h2>
        <p>گرگان، مرکز استان گلستان، با پیشینه‌ای غنی از تاریخ و فرهنگ، یکی از مقاصد جذاب گردشگری در شمال ایران است. از جنگل‌های انبوه و آبشارهای خروشان گرفته تا بناهای تاریخی و بازارهای سنتی، گرگان پذیرای گردشگران و مسافران عزیز است.</p>
        <p>اتاق اصناف شهرستان گرگان با همراهی اتحادیه‌های صنفی، همواره در خدمت فعالان حوزه گردشگری و مسافران محترم می‌باشد.</p>
        <div class="tourism-stats">
          <div class="tourism-stat"><strong>۲۵۰+</strong><span>جاذبه گردشگری</span></div>
          <div class="tourism-stat"><strong>۶۵۰+</strong><span>واحد اقامتی</span></div>
          <div class="tourism-stat"><strong>۱۲۰۰+</strong><span>صنف مرتبط</span></div>
        </div>
      </div>
      <div class="tourism-intro-img">
        <img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="گرگان" loading="lazy"/>
      </div>
    </div>
  </div>
</section>

<section class="tourism-attractions">
  <div class="site-container">
    <div class="section-heading section-heading-centered">
      <h2>جاذبه‌های گردشگری</h2>
      <p>با معروف‌ترین جاذبه‌های طبیعی، تاریخی و تفریحی گرگان آشنا شوید</p>
    </div>
    <div class="tabs" data-tab-group="tour-attractions" role="tablist">
      <button class="tab-pill active" data-tab-target="tour-nature" type="button">جاذبه‌های طبیعی</button>
      <button class="tab-pill" data-tab-target="tour-historic" type="button">جاذبه‌های تاریخی</button>
      <button class="tab-pill" data-tab-target="tour-modern" type="button">تفریحی و مدرن</button>
    </div>
    <div class="tab-panels" data-tab-panels="tour-attractions">
      <div class="tab-panel active" data-tab-panel="tour-nature">
        <div class="tourism-grid tourism-grid-lg">
          <div class="tourism-card tourism-card-lg">
            <a href="#">
              <div class="tourism-img-wrap">
                <img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="جنگل النگدره" loading="lazy"/>
                <div class="tourism-badge">طبیعت</div>
              </div>
            </a>
            <div class="tourism-card-body">
              <h3>جنگل النگدره</h3>
              <p>یکی از زیباترین و بکرترین جنگل‌های استان گلستان در جنوب شرقی گرگان واقع شده و با طبیعت سرسبز، هوای خنک و چشمه‌سارهای زلال، مقصدی ایده‌آل برای طبیعت‌گردان است.</p>
              <div class="tourism-card-footer"><span>📍 جنوب شرقی گرگان</span><span>🌲 جنگل انبوه</span></div>
            </div>
          </div>
          <div class="tourism-card tourism-card-lg">
            <a href="#">
              <div class="tourism-img-wrap">
                <img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="پارک ملی گلستان" loading="lazy"/>
                <div class="tourism-badge">طبیعت</div>
              </div>
            </a>
            <div class="tourism-card-body">
              <h3>پارک ملی گلستان</h3>
              <p>قدیمی‌ترین پارک ملی ایران با مساحتی بیش از ۹۰۰ کیلومتر مربع و تنوع زیستی فوق‌العاده شامل پستانداران، پرندگان و گونه‌های گیاهی کمیاب.</p>
              <div class="tourism-card-footer"><span>📍 شرق گلستان</span><span>🦌 ذخیره‌گاه زیست‌کره</span></div>
            </div>
          </div>
          <div class="tourism-card tourism-card-lg">
            <a href="#">
              <div class="tourism-img-wrap">
                <img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="آبشار کبودوال" loading="lazy"/>
                <div class="tourism-badge">طبیعت</div>
              </div>
            </a>
            <div class="tourism-card-body">
              <h3>آبشار کبودوال</h3>
              <p>آبشار دیدنی و خنک در دل جنگل‌های انبوه استان گلستان با ارتفاعی چشمگیر که در فصل بهار و تابستان جلوهای باشکوه دارد.</p>
              <div class="tourism-card-footer"><span>📍 علی‌آباد کتول</span><span>💧 آبشار فصلی</span></div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-panel" data-tab-panel="tour-historic">
        <div class="tourism-grid tourism-grid-lg">
          <div class="tourism-card tourism-card-lg">
            <a href="#">
              <div class="tourism-img-wrap">
                <img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="برج گنبد قابوس" loading="lazy"/>
                <div class="tourism-badge">تاریخی</div>
              </div>
            </a>
            <div class="tourism-card-body">
              <h3>برج گنبد قابوس</h3>
              <p>بلندترین برج تمام آجری جهان و یکی از شاهکارهای معماری دوران اسلامی که در فهرست میراث جهانی یونسکو به ثبت رسیده است.</p>
              <div class="tourism-card-footer"><span>📍 گنبد کاووس</span><span>🏛 یونسکو</span></div>
            </div>
          </div>
          <div class="tourism-card tourism-card-lg">
            <a href="#">
              <div class="tourism-img-wrap">
                <img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="دیوار دفاعی گرگان" loading="lazy"/>
                <div class="tourism-badge">تاریخی</div>
              </div>
            </a>
            <div class="tourism-card-body">
              <h3>دیوار دفاعی گرگان (مار سرخ)</h3>
              <p>پس از دیوار چین، طولانی‌ترین دیوار جهان با ۲۰۰ کیلومتر طول که در دوره ساسانیان ساخته شده و از اسرارآمیزترین بناهای تاریخی ایران است.</p>
              <div class="tourism-card-footer"><span>📍 شمال استان گلستان</span><span>🏛 دوره ساسانی</span></div>
            </div>
          </div>
          <div class="tourism-card tourism-card-lg">
            <a href="#">
              <div class="tourism-img-wrap">
                <img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="مسجد جامع گرگان" loading="lazy"/>
                <div class="tourism-badge">تاریخی</div>
              </div>
            </a>
            <div class="tourism-card-body">
              <h3>مسجد جامع گرگان</h3>
              <p>مسجدی با معماری زیبای دوره سلجوقیان در مرکز بافت تاریخی گرگان که با آجرکاری‌های نفیس و کتیبه‌های ارزشمند تزئین شده است.</p>
              <div class="tourism-card-footer"><span>📍 مرکز شهر گرگان</span><span>🏛 دوره سلجوقی</span></div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-panel" data-tab-panel="tour-modern">
        <div class="tourism-grid tourism-grid-lg">
          <div class="tourism-card tourism-card-lg">
            <a href="#">
              <div class="tourism-img-wrap">
                <img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="بازار بزرگ گرگان" loading="lazy"/>
                <div class="tourism-badge">خرید</div>
              </div>
            </a>
            <div class="tourism-card-body">
              <h3>بازار بزرگ گرگان</h3>
              <p>بازاری سنتی با راسته‌های طاق‌دار و حجره‌های متعدد که انواع محصولات محلی، صنایع دستی و سوغات استان گلستان را عرضه می‌کند.</p>
              <div class="tourism-card-footer"><span>📍 مرکز شهر گرگان</span><span>🛍 بازار سنتی</span></div>
            </div>
          </div>
          <div class="tourism-card tourism-card-lg">
            <a href="#">
              <div class="tourism-img-wrap">
                <img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="مجتمع تجاری گلستان" loading="lazy"/>
                <div class="tourism-badge">خرید</div>
              </div>
            </a>
            <div class="tourism-card-body">
              <h3>مجتمع تجاری گلستان</h3>
              <p>مرکز خرید مدرن و بزرگ با برندهای معتبر، فروشگاه‌های متنوع، هایپرمارکت و مجموعه تفریحی و رستوران‌های متنوع.</p>
              <div class="tourism-card-footer"><span>📍 بلوار گلستان</span><span>🛍 مرکز خرید مدرن</span></div>
            </div>
          </div>
          <div class="tourism-card tourism-card-lg">
            <a href="#">
              <div class="tourism-img-wrap">
                <img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="هتل شیرخان" loading="lazy"/>
                <div class="tourism-badge">اقامت</div>
              </div>
            </a>
            <div class="tourism-card-body">
              <h3>هتل شیرخان گرگان</h3>
              <p>هتل چهار ستاره با امکانات مدرن، رستوران، کافی‌شاپ و دسترسی آسان به مراکز دیدنی و تجاری شهر گرگان.</p>
              <div class="tourism-card-footer"><span>📍 خیابان شیرخان</span><span>🏨 هتل ۴ ستاره</span></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="tourism-gallery">
  <div class="site-container">
    <div class="section-heading section-heading-centered">
      <h2>گالری تصاویر گردشگری</h2>
      <p>تصاویری از زیبایی‌های طبیعی و تاریخی گرگان</p>
    </div>
    <div class="tourism-gallery-grid" data-gallery-group="tourism-gallery">
      <div class="tourism-gallery-item" data-gallery-item="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="تصویر طبیعت" loading="lazy"/></div>
      <div class="tourism-gallery-item" data-gallery-item="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="تصویر طبیعت" loading="lazy"/></div>
      <div class="tourism-gallery-item" data-gallery-item="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="تصویر طبیعت" loading="lazy"/></div>
      <div class="tourism-gallery-item" data-gallery-item="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="تصویر طبیعت" loading="lazy"/></div>
      <div class="tourism-gallery-item" data-gallery-item="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="تصویر طبیعت" loading="lazy"/></div>
      <div class="tourism-gallery-item" data-gallery-item="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="تصویر طبیعت" loading="lazy"/></div>
    </div>
  </div>
</section>

<section class="tourism-cta">
  <div class="site-container">
    <div class="tourism-cta-box">
      <h2>اصناف مرتبط با گردشگری</h2>
      <p>اتاق اصناف شهرستان گرگان با اتحادیه‌های هتل‌داران، رستوران‌داران، صنایع دستی و آژانس‌های مسافرتی در خدمت فعالان این حوزه است.</p>
      <a href="guild.html" class="cta-button">مشاهده اتحادیه‌های صنفی</a>
    </div>
  </div>
</section>
@endsection
