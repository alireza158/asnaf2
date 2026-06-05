@extends('frontend.layouts.app')

@section('title', $message->title.' | پیام تبریک')
@section('meta_description', Str::limit(strip_tags($message->body), 160))

@section('content')
<section class="page-header page-header-alt"><div class="site-container"><h1>{{ $message->title }}</h1><nav class="breadcrumb"><a href="{{ route('home') }}">خانه</a>@if($message->union)<a href="{{ route('guilds.show', $message->union->slug) }}">{{ $message->union->display_title }}</a>@endif<span>پیام تبریک</span></nav></div></section>
<section class="site-container"><div class="news-single-layout"><article class="news-single-main"><div class="news-single-body"><div class="post-meta"><span>{{ $message->union?->display_title ?: 'پیام عمومی' }}</span><span>{{ $message->published_at?->format('Y/m/d') }}</span></div><h2>{{ $message->title }}</h2><div>{!! $message->body ?: '<p>متن پیام به‌زودی تکمیل می‌شود.</p>' !!}</div></div></article><aside class="news-sidebar"><div class="news-sidebar-card">@if($message->manager_image)<img src="{{ Storage::url($message->manager_image) }}" alt="{{ $message->manager_name ?: $message->title }}" style="width:100%;height:220px;object-fit:cover;border-radius:18px" class="mb-3">@endif<h4>{{ $message->manager_name ?: 'مدیر اصناف' }}</h4><p>{{ $message->manager_position ?: 'مدیر' }}</p>@if($message->union)<a class="tab-pill" href="{{ route('guilds.show', $message->union->slug) }}">صفحه اتحادیه</a>@endif</div></aside></div></section>
@endsection
