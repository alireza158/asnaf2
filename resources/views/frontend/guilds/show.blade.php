@extends('frontend.layouts.app')

@section('title', 'اتحادیه صنف طلا و جواهر گرگان | اتاق اصناف شهرستان گرگان')
@section('meta_description', 'اطلاعات کامل اتحادیه صنف طلا و جواهر گرگان شامل اعضا، نرخ نامه، اخبار، تماس و گالری')

@section('content')
<div class="guild-hero">
<img alt="" class="guild-hero-bg" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/>
<div class="site-container guild-hero-content">
<div class="guild-hero-logo">ط</div>
<div class="guild-hero-text">
<nav class="breadcrumb-nav" style="margin-bottom:10px">
<a href="{{ route('home') }}" style="color:rgba(255,255,255,.6)">خانه</a>
<span class="breadcrumb-sep">/</span>
<a href="{{ route('home') }}#representatives" style="color:rgba(255,255,255,.6)">اتحادیه‌ها</a>
<span class="breadcrumb-sep">/</span>
<span style="color:rgba(255,255,255,.8)">اتحادیه صنف طلا و جواهر</span>
</nav>
<h1>اتحادیه صنف طلا و جواهر گرگان</h1>
<p>واحدهای فروش، ساخت و تعمیرات طلا و جواهر شهرستان گرگان</p>
<div class="guild-hero-stats">
<span>اعضا: <strong>۱۲۴</strong></span>
<span>واحد فعال: <strong>۹۸</strong></span>
<span>آخرین بروزرسانی: <strong>۱۴ اردیبهشت ۱۴۰۵</strong></span>
</div>
</div>
</div>
</div>

<main>
<div class="site-container guild-layout">
<aside class="guild-side-nav">
<h4>راهنمای سریع</h4>
<ul>
<li><a href="#guild-members">اعضای اصلی صنف</a></li>
<li><a href="#guild-commissions">کمیسیون‌ها</a></li>
<li><a href="#guild-rules">قوانین و دستورالعمل‌ها</a></li>
<li><a href="#guild-slider">اسلایدر خبری</a></li>
<li><a href="#guild-news">آخرین اخبار</a></li>
<li><a href="#guild-articles">مقاله‌ها</a></li>
<li><a href="#guild-prices">نرخ نامه</a></li>
<li><a href="#guild-complaint">ثبت شکایت صنفی</a></li>
<li><a href="#guild-minutes">صورتجلسه‌ها</a></li>
<li><a href="#guild-edu">آموزش</a></li>
<li><a href="#guild-announce">اطلاعیه و بخشنامه‌ها</a></li>
<li><a href="#guild-gallery">گالری تصاویر و ویدیو</a></li>
<li><a href="#guild-search">جستجو</a></li>
<li><a href="#guild-contact">تماس با ما</a></li>
</ul>
</aside>
<div>

<section class="guild-section guild-section-alt" id="guild-members" style="padding-top:0">
<h3 class="guild-section-title">رییس اتحادیه طلا و جواهر گرگان</h3>
<div class="guild-head-card">
<div class="guild-head-avatar">ع</div>
<div class="guild-head-info">
<strong>علی احمدی</strong>
<span>رییس اتحادیه طلا و جواهر شهرستان گرگان</span>
<p>علی احمدی با بیش از ۲۵ سال سابقه در صنف طلا و جواهر، از سال ۱۴۰۰ به عنوان رییس اتحادیه طلا و جواهر گرگان انتخاب شده است. ایشان مسئولیت پیگیری امور صنفی، هماهنگی با اتاق اصناف و نظارت بر فعالیت واحدهای طلافروشی شهرستان را بر عهده دارد.</p>
<div class="guild-head-contact">
<a href="#">تماس با رییس اتحادیه</a>
<a href="#">مشاهده رزومه</a>
</div>
</div>
</div>
</section>
<section class="guild-section guild-section-alt" id="guild-members">
<h3 class="guild-section-title">اعضای هیئت مدیره اتحادیه</h3>
<div class="guild-members-grid">
<div class="guild-member-card">
<div class="member-avatar">م</div>
<strong>محمد رضایی</strong>
<small>نایب رییس</small>
</div>
<div class="guild-member-card">
<div class="member-avatar">ح</div>
<strong>حسن کریمی</strong>
<small>دبیر اتحادیه</small>
</div>
<div class="guild-member-card">
<div class="member-avatar">س</div>
<strong>سعید موسوی</strong>
<small>عضو هیئت مدیره</small>
</div>
<div class="guild-member-card">
<div class="member-avatar">ر</div>
<strong>رضا صادقی</strong>
<small>بازرس</small>
</div>
<div class="guild-member-card">
<div class="member-avatar">ن</div>
<strong>ناصر حسینی</strong>
<small>عضو هیئت مدیره</small>
</div>
<div class="guild-member-card">
<div class="member-avatar">پ</div>
<strong>پیمان کاظمی</strong>
<small>عضو هیئت مدیره</small>
</div>
<div class="guild-member-card">
<div class="member-avatar">ج</div>
<strong>جواد علیزاده</strong>
<small>عضو علی‌البدل</small>
</div>
</div>
</section>

<section class="guild-section guild-section-alt" id="guild-commissions">
<h3 class="guild-section-title">کمیسیون‌های اتحادیه</h3>
<div class="guild-commission-list">
<div class="guild-commission-item">
<div class="com-num">۱</div>
<div>
<strong>کمیسیون نظارت و بازرسی</strong>
<small>نظارت بر واحدهای صنفی و رعایت مقررات</small>
</div>
</div>
<div class="guild-commission-item">
<div class="com-num">۲</div>
<div>
<strong>کمیسیون حل اختلاف</strong>
<small>رسیدگی به اختلافات صنفی بین اعضا و مشتریان</small>
</div>
</div>
<div class="guild-commission-item">
<div class="com-num">۳</div>
<div>
<strong>کمیسیون نرخ‌گذاری</strong>
<small>تعیین و بروزرسانی نرخ اجرت و خدمات</small>
</div>
</div>
<div class="guild-commission-item">
<div class="com-num">۴</div>
<div>
<strong>کمیسیون آموزش</strong>
<small>برگزاری دوره‌های آموزشی تخصصی</small>
</div>
</div>
</div>
</section>

<section class="guild-section guild-section-alt" id="guild-rules">
<h3 class="guild-section-title">قوانین و دستورالعمل‌ها</h3>
<div class="guild-2col">
<div class="guild-rules-list">
<div class="guild-rule-item">
<div class="rule-icon">📋</div>
<div>
<strong>دستورالعمل نحوه خرید و فروش طلا</strong>
<small>ابلاغیه جدید در خصوص ضوابط خرید و فروش و صدور فاکتور</small>
</div>
</div>
<div class="guild-rule-item">
<div class="rule-icon">📋</div>
<div>
<strong>ضوابط ساخت و تعمیرات طلا و جواهر</strong>
<small>آیین نامه اجرایی مربوط به واحدهای ساخت و تعمیرات</small>
</div>
</div>
<div class="guild-rule-item">
<div class="rule-icon">📋</div>
<div>
<strong>نرخ اجرت ساخت مصوب اتحادیه</strong>
<small>جدول نرخ اجرت ساخت انواع مصنوعات طلا و جواهر</small>
</div>
</div>
</div>
<div class="guild-rules-list">
<div class="guild-rule-item">
<div class="rule-icon">📋</div>
<div>
<strong>قوانین مالیاتی طلافروشان</strong>
<small>راهنمای تکالیف مالیاتی واحدهای صنفی طلا و جواهر</small>
</div>
</div>
<div class="guild-rule-item">
<div class="rule-icon">📋</div>
<div>
<strong>ضوابط بهداشتی و ایمنی</strong>
<small>الزامات بهداشتی و ایمنی محیط کسب و کار طلافروشی</small>
</div>
</div>
<div class="guild-rule-item">
<div class="rule-icon">📋</div>
<div>
<strong>قانون نظام صنفی - فصل طلا و جواهر</strong>
<small>مقررات اختصاصی صنف طلا و جواهر در قانون نظام صنفی</small>
</div>
</div>
</div>
</div>
</section>

<section class="guild-section" id="guild-slider">
<h3 class="guild-section-title">اسلایدر خبری اتحادیه</h3>
<div class="guild-news-slider swiper">
<div class="swiper-wrapper">
<div class="swiper-slide">
<img alt="خبر اسلایدر" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/>
<div class="slide-overlay"></div>
<div class="slide-text">
<h3>برگزاری نمایشگاه طلا و جواهر در گرگان</h3>
<span>۱۴ اردیبهشت ۱۴۰۵</span>
</div>
</div>
<div class="swiper-slide">
<img alt="خبر اسلایدر" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/>
<div class="slide-overlay"></div>
<div class="slide-text">
<h3>نشست تخصصی فعالان صنف طلا با مسئولین شهرستان</h3>
<span>۱۲ اردیبهشت ۱۴۰۵</span>
</div>
</div>
<div class="swiper-slide">
<img alt="خبر اسلایدر" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/>
<div class="slide-overlay"></div>
<div class="slide-text">
<h3>آیین نامه جدید ضوابط فروش طلا ابلاغ شد</h3>
<span>۱۰ اردیبهشت ۱۴۰۵</span>
</div>
</div>
</div>
    <div class="slider-arrows">
<button class="guild-slider-prev" type="button">‹</button>
<button class="guild-slider-next" type="button">›</button>
</div>
<div class="swiper-pagination"></div>
</div>
</section>

<section class="guild-section" id="guild-news">
<h3 class="guild-section-title">آخرین اخبار اتحادیه طلا و جواهر</h3>
<div class="guild-article-list">
<a class="guild-article-item" href="{{ route('posts.show', 'sample-post') }}">
<img alt="خبر طلا" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/>
<div>
<h4>نوسانات قیمت طلا و سکه در بازار گرگان</h4>
<p>آخرین تغییرات قیمت طلا و سکه در بازار گرگان به همراه تحلیل کارشناسان اقتصادی از روند بازار.</p>
<span class="item-date">۱۴ اردیبهشت ۱۴۰۵</span>
</div>
</a>
<a class="guild-article-item" href="{{ route('posts.show', 'sample-post') }}">
<img alt="خبر طلا" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/>
<div>
<h4>بازرسی دوره‌ای از طلافروشی‌های سطح شهر</h4>
<p>طرح بازرسی و نظارت بر واحدهای صنفی طلا و جواهر گرگان با هدف کنترل نرخ‌ها و رعایت ضوابط.</p>
<span class="item-date">۱۲ اردیبهشت ۱۴۰۵</span>
</div>
</a>
<a class="guild-article-item" href="{{ route('posts.show', 'sample-post') }}">
<img alt="خبر طلا" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/>
<div>
<h4>آموزش شناسایی طلای اصل و جلوگیری از تقلب</h4>
<p>دوره آموزشی رایگان برای اعضای اتحادیه در خصوص روش‌های تشخیص اصالت طلا و جواهر.</p>
<span class="item-date">۱۰ اردیبهشت ۱۴۰۵</span>
</div>
</a>
</div>
</section>

<section class="guild-section" id="guild-articles">
<h3 class="guild-section-title">مقاله‌ها</h3>
<div class="guild-3col">
<div class="archive-card">
<a href="{{ route('posts.show', 'sample-post') }}">
<img alt="مقاله" class="archive-card-img" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/>
<div class="archive-card-body">
<h2>راهنمای خرید طلا و جواهر</h2>
<p>نکات مهم و کلیدی برای خرید طلا و جواهر از واحدهای صنفی معتبر</p>
<span class="card-date">۱۴ اردیبهشت ۱۴۰۵</span>
</div>
</a>
</div>
<div class="archive-card">
<a href="{{ route('posts.show', 'sample-post') }}">
<img alt="مقاله" class="archive-card-img" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/>
<div class="archive-card-body">
<h2>تشخیص طلای اصل از بدل</h2>
<p>روش‌های کاربردی برای تشخیص اصالت طلا و جواهر در زمان خرید</p>
<span class="card-date">۱۲ اردیبهشت ۱۴۰۵</span>
</div>
</a>
</div>
<div class="archive-card">
<a href="{{ route('posts.show', 'sample-post') }}">
<img alt="مقاله" class="archive-card-img" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/>
<div class="archive-card-body">
<h2>تاثیر نوسانات ارز بر قیمت طلا</h2>
<p>تحلیل جامع از رابطه نرخ ارز و قیمت طلا در بازار ایران</p>
<span class="card-date">۱۰ اردیبهشت ۱۴۰۵</span>
</div>
</a>
</div>
</div>
</section>

<section class="guild-section guild-section-alt" id="guild-prices">
<h3 class="guild-section-title">نرخ نامه طلا و جواهر</h3>
<div class="price-table-wrap">
<table class="price-table">
<thead>
<tr>
<th>عنوان</th>
<th>قیمت (ریال)</th>
<th>نوع</th>
<th>تاریخ بروزرسانی</th>
</tr>
</thead>
<tbody>
<tr>
<td>قیمت هر گرم طلای ۱۸ عیار</td>
<td>۲۸,۵۰۰,۰۰۰</td>
<td>مصوب اتحادیه</td>
<td>۱۴ اردیبهشت ۱۴۰۵</td>
</tr>
<tr>
<td>قیمت سکه تمام بهار آزادی</td>
<td>۳۱۲,۰۰۰,۰۰۰</td>
<td>بازار آزاد</td>
<td>۱۴ اردیبهشت ۱۴۰۵</td>
</tr>
<tr>
<td>قیمت نیم سکه</td>
<td>۱۸۵,۰۰۰,۰۰۰</td>
<td>بازار آزاد</td>
<td>۱۴ اردیبهشت ۱۴۰۵</td>
</tr>
<tr>
<td>قیمت ربع سکه</td>
<td>۱۲۰,۰۰۰,۰۰۰</td>
<td>بازار آزاد</td>
<td>۱۴ اردیبهشت ۱۴۰۵</td>
</tr>
<tr>
<td>اجرت ساخت هر گرم مصنوعات طلا</td>
<td>۸۵۰,۰۰۰</td>
<td>مصوب اتحادیه</td>
<td>۱۴ اردیبهشت ۱۴۰۵</td>
</tr>
<tr>
<td>هزینه تعمیرات طلا (هر گرم)</td>
<td>۴۵۰,۰۰۰</td>
<td>مصوب اتحادیه</td>
<td>۱۴ اردیبهشت ۱۴۰۵</td>
</tr>
</tbody>
</table>
</div>
</section>

<section class="guild-section guild-section-alt" id="guild-complaint">
<h3 class="guild-section-title">ثبت شکایت صنفی</h3>
<div class="guild-2col">
<div class="guild-info-card">
<h4>نحوه ثبت شکایت</h4>
<p>شهروندان می‌توانند شکایات خود را در خصوص واحدهای صنفی طلا و جواهر به صورت حضوری یا اینترنتی ثبت نمایند. شکایات دریافت شده حداکثر ظرف ۴۸ ساعت توسط کمیسیون رسیدگی بررسی می‌شود.</p>
<ul>
<li>مراجعه حضوری به دفتر اتحادیه</li>
<li>ثبت آنلاین شکایت از طریق سامانه</li>
<li>تماس تلفنی با شماره ۰۱۷۳۲۱۵۲۹۱۲</li>
</ul>
</div>
<div class="guild-complaint-cta">
<strong>ثبت شکایت آنلاین</strong>
<a class="tab-pill active" href="#">ثبت شکایت جدید</a>
<a class="tab-pill" href="#">پیگیری شکایت قبلی</a>
</div>
</div>
</section>

<section class="guild-section guild-section-alt" id="guild-minutes">
<h3 class="guild-section-title">صورتجلسه‌های اجرایی</h3>
<div class="guild-minutes-list">
<div class="guild-minute-item">
<div class="minute-info">
<strong>صورتجلسه شماره ۱۴۵ - هیئت مدیره اتحادیه</strong>
<span>۱۴ اردیبهشت ۱۴۰۵</span>
</div>
<a class="minute-dl" href="#">دانلود PDF</a>
</div>
<div class="guild-minute-item">
<div class="minute-info">
<strong>صورتجلسه شماره ۱۴۴ - کمیسیون نظارت</strong>
<span>۱۰ اردیبهشت ۱۴۰۵</span>
</div>
<a class="minute-dl" href="#">دانلود PDF</a>
</div>
<div class="guild-minute-item">
<div class="minute-info">
<strong>صورتجلسه مجمع عمومی عادی اتحادیه</strong>
<span>۵ اردیبهشت ۱۴۰۵</span>
</div>
<a class="minute-dl" href="#">دانلود PDF</a>
</div>
<div class="guild-minute-item">
<div class="minute-info">
<strong>صورتجلسه شماره ۱۴۳ - کمیسیون فنی</strong>
<span>۱ اردیبهشت ۱۴۰۵</span>
</div>
<a class="minute-dl" href="#">دانلود PDF</a>
</div>
</div>
</section>

<section class="guild-section guild-section-alt" id="guild-edu">
<h3 class="guild-section-title">آموزش</h3>
<div class="guild-4col">
<div class="guild-edu-item">
<div class="edu-icon">📚</div>
<strong>دوره احکام تجارت</strong>
<span>آموزش قوانین و مقررات صنفی</span>
</div>
<div class="guild-edu-item">
<div class="edu-icon">🔍</div>
<strong>شناسایی طلای اصل</strong>
<span>روش‌های تشخیص اصالت طلا</span>
</div>
<div class="guild-edu-item">
<div class="edu-icon">💰</div>
<strong>مدیریت مالی صنف</strong>
<span>اصول حسابداری و مالیات</span>
</div>
<div class="guild-edu-item">
<div class="edu-icon">🛡️</div>
<strong>بیمه صنفی</strong>
<span>آموزش پوشش‌های بیمه‌ای</span>
</div>
</div>
</section>

<section class="guild-section guild-section-alt" id="guild-announce">
<h3 class="guild-section-title">اطلاعیه و بخشنامه‌ها</h3>
<div class="guild-announce-list">
<div class="guild-announce-item">
<div class="announce-badge"></div>
<strong>ابلاغیه نرخ جدید اجرت ساخت طلا</strong>
<span>۱۴ اردیبهشت ۱۴۰۵</span>
</div>
<div class="guild-announce-item">
<div class="announce-badge"></div>
<strong>بخشنامه ضوابط جدید صدور فاکتور فروش</strong>
<span>۱۰ اردیبهشت ۱۴۰۵</span>
</div>
<div class="guild-announce-item">
<div class="announce-badge"></div>
<strong>اطلاعیه تعطیلات و ساعات کاری اتحادیه</strong>
<span>۸ اردیبهشت ۱۴۰۵</span>
</div>
<div class="guild-announce-item">
<div class="announce-badge"></div>
<strong>بخشنامه مالیاتی ویژه صنف طلا و جواهر</strong>
<span>۵ اردیبهشت ۱۴۰۵</span>
</div>
</div>
</section>

<section class="guild-section" id="guild-gallery">
<h3 class="guild-section-title">گالری تصاویر و ویدیو</h3>
<div class="guild-gallery-tabs" data-tab-group="guild-gallery">
<button class="tab-pill active" data-tab-target="gallery-image" type="button">تصاویر</button>
<button class="tab-pill" data-tab-target="gallery-video" type="button">ویدیوها</button>
</div>
<div class="tab-panels" data-tab-panels="guild-gallery">
<div class="tab-panel active" data-tab-panel="gallery-image">
<div class="guild-gallery-grid">
<div class="guild-gallery-item"><img alt="گالری" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/></div>
<div class="guild-gallery-item"><img alt="گالری" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/></div>
<div class="guild-gallery-item"><img alt="گالری" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/></div>
<div class="guild-gallery-item"><img alt="گالری" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/></div>
</div>
</div>
<div class="tab-panel" data-tab-panel="gallery-video">
<div class="guild-gallery-grid">
<div class="guild-gallery-item video"><img alt="گالری ویدیو" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/></div>
<div class="guild-gallery-item video"><img alt="گالری ویدیو" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/></div>
<div class="guild-gallery-item video"><img alt="گالری ویدیو" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/></div>
<div class="guild-gallery-item video"><img alt="گالری ویدیو" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/></div>
</div>
</div>
</div>
<div class="guild-gallery-more">
<a href="{{ route('home') }}#multimedia">مشاهده همه تصاویر و ویدیوها</a>
</div>
</section>

<section class="guild-section" id="guild-search">
<h3 class="guild-section-title">جستجو در اتحادیه طلا و جواهر</h3>
<p class="guild-search-desc">عبارت مورد نظر خود را در میان اخبار، اعضا، قوانین و اطلاعات اتحادیه جستجو کنید</p>
<div class="guild-search-box">
<input placeholder="جستجو در اخبار، اعضا، قوانین و..." type="search"/>
<button type="button">جستجو</button>
</div>
</section>

<section class="guild-section" id="guild-contact">
<h3 class="guild-section-title">تماس با اتحادیه طلا و جواهر گرگان</h3>
<div class="guild-contact-grid">
<div class="guild-contact-card">
<div class="contact-icon">📍</div>
<div>
<strong>آدرس</strong>
<span>گرگان، خیابان امام خمینی، مجتمع تجاری طلا و جواهر، طبقه دوم، واحد ۲۰</span>
</div>
</div>
<div class="guild-contact-card">
<div class="contact-icon">📞</div>
<div>
<strong>تلفن</strong>
<span>۰۱۷-۳۲۲۲۵۵۶۶</span>
</div>
</div>
<div class="guild-contact-card">
<div class="contact-icon">📠</div>
<div>
<strong>فکس</strong>
<span>۰۱۷-۳۲۲۲۵۵۶۷</span>
</div>
</div>
<div class="guild-contact-card">
<div class="contact-icon">✉️</div>
<div>
<strong>ایمیل</strong>
<span>gold.ggn@asnaf-gorgan.ir</span>
</div>
</div>
</div>
<div class="guild-social">
<a href="#" aria-label="اینستاگرام">📷</a>
<a href="#" aria-label="تلگرام">✈️</a>
<a href="#" aria-label="واتساپ">💬</a>
<a href="#" aria-label="ایتا">📱</a>
<a href="#" aria-label="بله">🔵</a>
<a href="#" aria-label="سروش">🟢</a>
</div>
</section>

</div>
</div>
</main>
@endsection
