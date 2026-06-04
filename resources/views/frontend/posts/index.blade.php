@extends('frontend.layouts.app')

@section('title', 'آرشیو نوشته‌ها | اتاق اصناف شهرستان گرگان')
@section('meta_description', 'آرشیو کامل اخبار، اطلاعیه‌ها و نوشته‌های اتاق اصناف شهرستان گرگان')

@section('content')
<div class="page-header">
<div class="site-container">
<nav class="breadcrumb-nav">
<a href="{{ route('frontend.home') }}">خانه</a>
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
<button class="tab-pill active" type="button">همه</button>
<button class="tab-pill" type="button">اخبار</button>
<button class="tab-pill" type="button">اطلاعیه‌ها</button>
<button class="tab-pill" type="button">آموزش</button>
<button class="tab-pill" type="button">گردشگری</button>
</div>
</div>
<div class="archive-grid">
<article class="archive-card">
<a href="{{ route('frontend.posts.show', 'sample-post') }}">
<img alt="تصویر خبر" class="archive-card-img" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/>
<div class="archive-card-body">
<span class="card-cat">اخبار</span>
<h2>آخرین اخبار و اطلاعیه‌های اتاق اصناف گرگان</h2>
<p>خلاصه‌ای از آخرین رویدادها و اطلاعیه‌های مهم اتاق اصناف شهرستان گرگان که در این مطلب به آنها پرداخته شده است.</p>
<span class="card-date">۱۴ اردیبهشت ۱۴۰۵</span>
</div>
</a>
</article>
<article class="archive-card">
<a href="{{ route('frontend.posts.show', 'sample-post') }}">
<img alt="تصویر راهنمای صدور پروانه" class="archive-card-img" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/>
<div class="archive-card-body">
<span class="card-cat">آموزش</span>
<h2>راهنمای جامع صدور و تمدید پروانه کسب ۱۴۰۵</h2>
<p>مراحل کامل صدور، تمدید و انتقال پروانه کسب به همراه مدارک مورد نیاز و هزینه‌های مربوطه در این راهنما ارائه شده است.</p>
<span class="card-date">۱۲ اردیبهشت ۱۴۰۵</span>
</div>
</a>
</article>
<article class="archive-card">
<a href="{{ route('frontend.posts.show', 'sample-post') }}">
<img alt="تصویر دوره آموزشی" class="archive-card-img" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/>
<div class="archive-card-body">
<span class="card-cat">آموزش</span>
<h2>برگزاری دوره آموزشی احکام تجارت برای متقاضیان</h2>
<p>دوره آموزش احکام تجارت و کسب‌وکار ویژه متقاضیان دریافت پروانه کسب در محل اتاق اصناف برگزار می‌شود.</p>
<span class="card-date">۱۰ اردیبهشت ۱۴۰۵</span>
</div>
</a>
</article>
<article class="archive-card">
<a href="{{ route('frontend.posts.show', 'sample-post') }}">
<img alt="تصویر بازرسی" class="archive-card-img" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/>
<div class="archive-card-body">
<span class="card-cat">اخبار</span>
<h2>بازرسی دوره‌ای از واحدهای صنفی شهرستان گرگان</h2>
<p>طرح بازرسی دوره‌ای از واحدهای صنفی سطح شهرستان گرگان توسط بازرسان اتاق اصناف در حال اجرا می‌باشد.</p>
<span class="card-date">۸ اردیبهشت ۱۴۰۵</span>
</div>
</a>
</article>
<article class="archive-card">
<a href="{{ route('frontend.posts.show', 'sample-post') }}">
<img alt="تصویر نشست هماهنگی" class="archive-card-img" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/>
<div class="archive-card-body">
<span class="card-cat">اخبار</span>
<h2>نشست هماهنگی اتحادیه‌های صنفی با اداره صمت</h2>
<p>جلسه هماهنگی و هم‌اندیشی اتحادیه‌های صنفی شهرستان گرگان با حضور نمایندگان اداره صنعت، معدن و تجارت برگزار شد.</p>
<span class="card-date">۶ اردیبهشت ۱۴۰۵</span>
</div>
</a>
</article>
<article class="archive-card">
<a href="{{ route('frontend.posts.show', 'sample-post') }}">
<img alt="تصویر گردشگری" class="archive-card-img" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/>
<div class="archive-card-body">
<span class="card-cat">گردشگری</span>
<h2>جاذبه‌های گردشگری گرگان و نقش اصناف در توسعه آن</h2>
<p>نقش اتحادیه‌های صنفی و اصناف مختلف در توسعه صنعت گردشگری شهرستان گرگان و جذب گردشگران داخلی و خارجی.</p>
<span class="card-date">۴ اردیبهشت ۱۴۰۵</span>
</div>
</a>
</article>
<article class="archive-card">
<a href="{{ route('frontend.posts.show', 'sample-post') }}">
<img alt="تصویر بخشنامه" class="archive-card-img" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/>
<div class="archive-card-body">
<span class="card-cat">اطلاعیه‌ها</span>
<h2>ابلاغیه جدید در خصوص نرخ‌نامه صنفی سال ۱۴۰۵</h2>
<p>بخشنامه جدید سازمان صمت در خصوص نرخ‌نامه کالا و خدمات صنفی جهت اجرا به اتحادیه‌های صنفی ابلاغ گردید.</p>
<span class="card-date">۲ اردیبهشت ۱۴۰۵</span>
</div>
</a>
</article>
<article class="archive-card">
<a href="{{ route('frontend.posts.show', 'sample-post') }}">
<img alt="تصویر سامانه نوین" class="archive-card-img" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/>
<div class="archive-card-body">
<span class="card-cat">اطلاعیه‌ها</span>
<h2>راهنمای استفاده از سامانه نوین اصناف</h2>
<p>آموزش تصویری و گام به گام نحوه استفاده از سامانه نوین اصناف برای صدور، تمدید و پیگیری درخواست‌های صنفی.</p>
<span class="card-date">۳۰ فروردین ۱۴۰۵</span>
</div>
</a>
</article>
<article class="archive-card">
<a href="{{ route('frontend.posts.show', 'sample-post') }}">
<img alt="تصویر آموزش مالیات" class="archive-card-img" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/>
<div class="archive-card-body">
<span class="card-cat">آموزش</span>
<h2>راهنمای تکالیف مالیاتی واحدهای صنفی</h2>
<p>آشنایی با مهمترین تکالیف مالیاتی صنوف مختلف و راهنمای ارائه اظهارنامه مالیاتی برای کسب‌وکارهای صنفی.</p>
<span class="card-date">۲۸ فروردین ۱۴۰۵</span>
</div>
</a>
</article>
</div>
<nav class="pagination-nav">
<span class="current">۱</span>
<a href="#">۲</a>
<a href="#">۳</a>
<a href="#">...</a>
<a href="#">۱۰</a>
<a href="#">←</a>
</nav>
</div>
</main>
@endsection
