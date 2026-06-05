@extends('frontend.layouts.app')
@section('title', 'کمیسیون‌ها | اتاق اصناف شهرستان گرگان')
@section('meta_description', 'معرفی کمیسیون‌های اتاق اصناف شهرستان گرگان و جلسات مرتبط')
@section('frontend_variant', 'compact')
@section('footer_links_variant', 'short')
@section('content')
<section class="page-header page-header-alt"><div class="site-container"><h1>کمیسیون‌ها</h1><nav class="breadcrumb"><a href="{{ route('home') }}">خانه</a><span>کمیسیون‌ها</span></nav></div></section>
<section class="site-container"><div class="section-heading section-heading-centered"><h2>کمیسیون‌های اتاق اصناف</h2><p>معرفی کمیسیون‌ها، اعضا و جلسات منتشرشده</p></div><div class="commission-card"><div class="commission-grid compact-grid">@forelse($commissions as $index=>$commission)<a class="commission-item {{ $index % 2 ? 'green' : 'blue' }}" href="{{ route('commissions.show', $commission->slug) }}"><strong>{{ $commission->title }}</strong><span>{{ Str::limit(strip_tags($commission->description), 120) ?: 'اطلاعات این کمیسیون به‌زودی تکمیل می‌شود.' }}</span><small>{{ $commission->sessions_count }} جلسه منتشرشده</small></a>@empty<p class="text-muted text-center">کمیسیونی برای نمایش وجود ندارد.</p>@endforelse</div></div><div class="mt-4">{{ $commissions->links() }}</div></section>
@endsection
