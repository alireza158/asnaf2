@extends('frontend.layouts.app')

@section('title', 'اتحادیه‌های صنفی | اتاق اصناف مرکز استان گلستان')
@section('meta_description', 'فهرست اتحادیه‌های صنفی فعال استان گلستان بر اساس نوع و دسته‌بندی')

@php
    $assetImage = fn (?string $path) => image_url($path, 'assets/img/asnaf-gorgan-default.jpg');
    $typeLabels = ($unionTypes ?? collect())->pluck('title', 'slug')->all();
@endphp

@section('content')
<div class="page-header">
    <div class="site-container">
        <nav class="breadcrumb-nav"><a href="{{ route('home') }}">خانه</a><span class="breadcrumb-sep">/</span><span>اتحادیه‌ها</span></nav>
        <h1>اتحادیه‌های صنفی</h1>
    </div>
</div>

<main class="archive-page">
    <div class="site-container">
        <div class="archive-header"><h1>فهرست اتحادیه‌های فعال</h1></div>

        <form class="guild-filter-card" action="{{ route('guilds.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-lg-5 col-md-6">
                    <label class="form-label" for="guildSearch">جستجو بر اساس عنوان اتحادیه</label>
                    <input id="guildSearch" class="form-control" name="search" value="{{ $search }}" placeholder="مثلاً اتحادیه پوشاک یا نانوایان" type="search">
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label" for="guildType">نوع اتحادیه</label>
                    <select id="guildType" class="form-control" name="type">
                        <option value="">همه نوع‌ها</option>
                        @foreach($typeLabels as $key => $label)
                            <option value="{{ $key }}" @selected($type === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label" for="guildCategory">دسته‌بندی اتحادیه</label>
                    <select id="guildCategory" class="form-control" name="category_id">
                        <option value="">همه دسته‌بندی‌ها</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected((string) $categoryId === (string) $category->id)>{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-1 col-md-6 d-flex gap-2">
                    <button class="tab-pill active w-100" type="submit">اعمال</button>
                </div>
            </div>
            @if ($search !== '' || $type !== '' || $categoryId !== '')<a class="tab-pill mt-3" href="{{ route('guilds.index') }}">حذف فیلترها</a>@endif
        </form>

        @if ($search === '' && $type === '' && $categoryId === '')
            <div class="media-tabs" data-tab-group="guild-types">
                @foreach ($typeTabs as $key => $tab)
                    <button class="media-tab @if($loop->first) active @endif" data-tab-target="guild-type-{{ $key }}" type="button">{{ trim(($tab['icon'] ?? '').' '.$tab['label']) }}</button>
                @endforeach
            </div>
            <div class="tab-panels" data-tab-panels="guild-types">
                @foreach ($typeTabs as $key => $tab)
                    <div class="tab-panel @if($loop->first) active @endif" data-tab-panel="guild-type-{{ $key }}">
                        <div class="archive-grid">
                            @forelse ($tab['items'] as $union)
                                @include('frontend.guilds.partials.card', ['union' => $union, 'assetImage' => $assetImage])
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
                    @include('frontend.guilds.partials.card', ['union' => $union, 'assetImage' => $assetImage])
                @empty
                    <p class="text-center">اتحادیه فعالی با معیارهای انتخاب‌شده یافت نشد.</p>
                @endforelse
            </div>
            {{ $unions->links('frontend.partials.pagination') }}
        @endif
    </div>
</main>
@endsection
