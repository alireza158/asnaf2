@extends('frontend.layouts.app')

@section('title', 'اتحادیه‌های صنفی گرگان | اتاق اصناف مرکز استان گلستان')
@section('meta_description', 'فهرست اتحادیه‌های صنفی فعال شهرستان گرگان بر اساس نوع و دسته‌بندی')

@php
    $assetImage = function (?string $path) {
        if (blank($path)) return asset('assets/img/asnaf-gorgan-default.jpg');
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/'])) return $path;
        if (\Illuminate\Support\Str::startsWith($path, 'assets/')) return asset($path);
        return Storage::url($path);
    };
    $typeTabs = [
        'production' => ['label' => 'اتحادیه‌های تولیدی', 'items' => $productionUnions],
        'distribution' => ['label' => 'اتحادیه‌های توزیعی', 'items' => $distributionUnions],
        'service' => ['label' => 'اتحادیه‌های خدماتی', 'items' => $serviceUnions],
        'specialized' => ['label' => 'اتحادیه‌های تخصصی', 'items' => $specializedUnions],
    ];
@endphp

@section('content')
<div class="page-header">
    <div class="site-container">
        <nav class="breadcrumb-nav"><a href="{{ route('home') }}">خانه</a><span class="breadcrumb-sep">/</span><span>اتحادیه‌ها</span></nav>
        <h1>اتحادیه‌های صنفی گرگان</h1>
    </div>
</div>

<main class="archive-page">
    <div class="site-container">
        <div class="archive-header"><h1>فهرست اتحادیه‌های فعال</h1></div>

        <form class="archive-filters" action="{{ route('guilds.index') }}" method="GET">
            <input class="form-control" name="search" value="{{ $search }}" placeholder="جستجوی عنوان، مدیر یا توضیح اتحادیه..." type="search">
            <button class="tab-pill active" type="submit">جستجو</button>
            @if ($search !== '')<a class="tab-pill" href="{{ route('guilds.index') }}">حذف جستجو</a>@endif
        </form>

        @if($categories->isNotEmpty())
            <div class="archive-filters">
                @foreach($categories as $category)
                    <span class="tab-pill">{{ $category->title }}</span>
                @endforeach
            </div>
        @endif

        @if ($search === '')
            <div class="media-tabs" data-tab-group="guild-types">
                @foreach ($typeTabs as $key => $tab)
                    <button class="media-tab @if($loop->first) active @endif" data-tab-target="guild-type-{{ $key }}" type="button">{{ $tab['label'] }}</button>
                @endforeach
            </div>
            <div class="tab-panels" data-tab-panels="guild-types">
                @foreach ($typeTabs as $key => $tab)
                    <div class="tab-panel @if($loop->first) active @endif" data-tab-panel="guild-type-{{ $key }}">
                        <div class="archive-grid">
                            @forelse ($tab['items'] as $union)
                                <article class="archive-card">
                                    <a href="{{ route('guilds.show', $union->slug) }}">
                                        <img alt="{{ $union->display_title }}" class="archive-card-img" src="{{ $assetImage($union->cover_image) }}">
                                        <div class="archive-card-body">
                                            <span class="card-cat">{{ $union->category?->title ?: $union->union_type_label }}</span>
                                            <h2>{{ $union->display_title }}</h2>
                                            <p>{{ $union->short_description ?: Str::limit(strip_tags($union->description), 150) }}</p>
                                            @if ($union->manager_name)<span class="card-date">مدیر: {{ $union->manager_name }}</span>@endif
                                            @if ($union->phone)<span class="card-date">{{ $union->phone }}</span>@endif
                                        </div>
                                    </a>
                                </article>
                            @empty
                                <p class="text-center">در این نوع اتحادیه فعالی ثبت نشده است.</p>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="archive-grid">
                @forelse ($unions as $union)
                    <article class="archive-card">
                        <a href="{{ route('guilds.show', $union->slug) }}">
                            <img alt="{{ $union->display_title }}" class="archive-card-img" src="{{ $assetImage($union->cover_image) }}">
                            <div class="archive-card-body">
                                <span class="card-cat">{{ $union->category?->title ?: $union->union_type_label }}</span>
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
        @endif
    </div>
</main>
@endsection
