@extends('frontend.layouts.app')

@section('title', 'اتحادیه‌های صنفی گرگان | اتاق اصناف مرکز استان گلستان')
@section('meta_description', 'فهرست اتحادیه‌های صنفی فعال شهرستان گرگان')

@section('content')
<div class="page-header">
    <div class="site-container">
        <nav class="breadcrumb-nav">
            <a href="{{ route('home') }}">خانه</a>
            <span class="breadcrumb-sep">/</span>
            <span>اتحادیه‌ها</span>
        </nav>
        <h1>اتحادیه‌های صنفی گرگان</h1>
    </div>
</div>

<main class="archive-page">
    <div class="site-container">
        <div class="archive-header">
            <h1>فهرست اتحادیه‌های فعال</h1>
        </div>

        <form class="archive-filters" action="{{ route('guilds.index') }}" method="GET">
            <input class="form-control" name="search" value="{{ $search }}" placeholder="جستجوی عنوان، مدیر یا توضیح اتحادیه..." type="search">
            <button class="tab-pill active" type="submit">جستجو</button>
            @if ($search !== '')<a class="tab-pill" href="{{ route('guilds.index') }}">حذف جستجو</a>@endif
        </form>

        <div class="archive-grid">
            @forelse ($unions as $union)
                <article class="archive-card">
                    <a href="{{ route('guilds.show', $union->slug) }}">
                        <img alt="{{ $union->display_title }}" class="archive-card-img" src="{{ $union->cover_image ? Storage::url($union->cover_image) : asset('assets/img/asnaf-gorgan-default.jpg') }}">
                        <div class="archive-card-body">
                            <span class="card-cat">اتحادیه صنفی</span>
                            <h2>{{ $union->display_title }}</h2>
                            <p>{{ $union->short_description ?: Str::limit(strip_tags($union->description), 150) }}</p>
                            @if ($union->manager_name)<span class="card-date">مدیر: {{ $union->manager_name }}</span>@endif
                            @if ($union->phone)<span class="card-date">{{ $union->phone }}</span>@endif
                        </div>
                    </a>
                </article>
            @empty
                <p class="text-center">اتحادیه فعالی با معیارهای انتخاب‌شده یافت نشد.</p>
            @endforelse
        </div>

        {{ $unions->links('frontend.partials.pagination') }}
    </div>
</main>
@endsection
