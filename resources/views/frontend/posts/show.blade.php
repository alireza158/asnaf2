@extends('frontend.layouts.app')

@section('title', 'عنوان نوشته | اتاق اصناف شهرستان گرگان')
@section('meta_description', 'توضیحات نوشته در صفحه داخلی اتاق اصناف شهرستان گرگان')

@section('content')
<div class="page-header">
<div class="site-container">
<nav class="breadcrumb-nav">
<a href="index.html">خانه</a>
<span class="breadcrumb-sep">/</span>
<a href="archive.html">اخبار</a>
<span class="breadcrumb-sep">/</span>
<span>عنوان نوشته</span>
</nav>
<h1>عنوان نوشته</h1>
</div>
</div>

<main>
<div class="site-container single-post-layout">
<article class="single-post-article">
<img alt="تصویر شاخص نوشته" class="post-featured-img" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/>
<div class="single-post-body">
<div class="post-meta">
<span>تاریخ انتشار: ۱۴ اردیبهشت ۱۴۰۵</span>
<span class="dot"></span>
<span>دسته‌بندی: اخبار اتاق اصناف</span>
<span class="dot"></span>
<span>بازدید: ۲۵۶</span>
</div>
<h1>عنوان اصلی نوشته یا خبر</h1>
<div class="post-excerpt">
خلاصه یا چکیده کوتاهی از محتوای این نوشته که توجه مخاطب را جلب می‌کند و او را به مطالعه ادامه مطلب ترغیب می‌نماید.
</div>
<div class="post-content">
<p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می‌باشد.</p>
<p>کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می‌طلبد تا با نرم‌افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد.</p>
<p>در این صورت می‌توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p>
</div>
<div class="post-gallery" data-gallery-group="post-g1">
<h3>گالری تصاویر</h3>
<div class="post-gallery-grid">
<div class="post-gallery-item" data-gallery-item="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="تصویر ۱" loading="lazy"/></div>
<div class="post-gallery-item" data-gallery-item="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="تصویر ۲" loading="lazy"/></div>
<div class="post-gallery-item" data-gallery-item="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="تصویر ۳" loading="lazy"/></div>
<div class="post-gallery-item" data-gallery-item="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"><img src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="تصویر ۴" loading="lazy"/></div>
</div>
</div>
<div class="post-tags">
<span class="post-tag">اصناف</span>
<span class="post-tag">گرگان</span>
<span class="post-tag">پروانه کسب</span>
<span class="post-tag">آموزش</span>
</div>
<div class="post-nav">
<a class="post-nav-link post-nav-prev" href="#">
<span>→ نوشته قبلی</span>
<strong>عنوان نوشته قبلی</strong>
</a>
<a class="post-nav-link post-nav-next" href="#">
<span>نوشته بعدی ←</span>
<strong>عنوان نوشته بعدی</strong>
</a>
</div>
</div>
</article>
<aside class="single-post-sidebar">
<div class="sidebar-card">
<h3>آخرین نوشته‌ها</h3>
<ul class="sidebar-list">
<li><a href="single-post.html">آخرین اخبار و اطلاعیه‌های اتاق اصناف گرگان</a></li>
<li><a href="single-post.html">راهنمای صدور و تمدید پروانه کسب در سال ۱۴۰۵</a></li>
<li><a href="single-post.html">برگزاری دوره آموزشی احکام تجارت برای متقاضیان</a></li>
<li><a href="single-post.html">بازرسی دوره‌ای از واحدهای صنفی شهرستان گرگان</a></li>
<li><a href="single-post.html">نشست هماهنگی اتحادیه‌های صنفی با اداره صمت</a></li>
</ul>
</div>
<div class="sidebar-card">
<h3>دسته‌بندی‌ها</h3>
<ul class="sidebar-list">
<li><a href="archive.html">اخبار اتاق اصناف</a></li>
<li><a href="archive.html">اطلاعیه‌ها و بخشنامه‌ها</a></li>
<li><a href="archive.html">آموزش و دوره‌ها</a></li>
<li><a href="archive.html">اخبار اتحادیه‌ها</a></li>
<li><a href="archive.html">گردشگری و اصناف</a></li>
</ul>
</div>
<div class="sidebar-card">
<h3>برچسب‌ها</h3>
<div class="post-tags">
<span class="post-tag">پروانه کسب</span>
<span class="post-tag">آموزش</span>
<span class="post-tag">بازرسی</span>
<span class="post-tag">نرخ نامه</span>
<span class="post-tag">اصناف</span>
</div>
</div>
</aside>
</div>
</main>
@endsection
