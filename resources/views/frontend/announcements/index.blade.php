@extends('frontend.layouts.app')

@section('title', 'آرشیو اطلاعیه‌ها | اتاق اصناف شهرستان گرگان')
@section('meta_description', 'آرشیو اطلاعیه‌های منتشرشده اتاق اصناف شهرستان گرگان')

@section('content')
<div class="page-header">
    <div class="site-container">
        <nav class="breadcrumb-nav">
            <a href="{{ route('home') }}">خانه</a>
            <span class="breadcrumb-sep">/</span>
            <span>آرشیو اطلاعیه‌ها</span>
        </nav>
        <h1>آرشیو اطلاعیه‌ها</h1>
    </div>
</div>

<main class="archive-page">
    <div class="site-container">
        <div class="archive-header">
            <h1>همه اطلاعیه‌های فعال</h1>
        </div>

        <form class="archive-filters" action="{{ route('announcements.index') }}" method="GET">
            <input class="form-control" name="search" value="{{ $search }}" placeholder="جستجو در اطلاعیه‌ها..." type="search">
            <select class="form-control" name="category_id" aria-label="فیلتر دسته‌بندی">
                <option value="">همه دسته‌بندی‌ها</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) $categoryId === (string) $category->id)>{{ $category->title }}</option>
                @endforeach
            </select>
            <select class="form-control" name="union_id" aria-label="فیلتر اتحادیه">
                <option value="">همه اتحادیه‌ها و اطلاعیه‌های عمومی</option>
                @foreach ($unions as $union)
                    <option value="{{ $union->id }}" @selected((string) $unionId === (string) $union->id)>{{ $union->name }}</option>
                @endforeach
            </select>
            <button class="tab-pill active" type="submit">اعمال فیلتر</button>
            @if ($search !== '' || $categoryId || $unionId)
                <a class="tab-pill" href="{{ route('announcements.index') }}">حذف فیلتر</a>
            @endif
        </form>

        <div class="archive-grid">
            @forelse ($announcements as $announcement)
                <article class="archive-card">
                    <a href="{{ route('announcements.show', $announcement->slug) }}">
                        <img alt="{{ $announcement->title }}" class="archive-card-img" src="{{ $announcement->featured_image ? Storage::url($announcement->featured_image) : asset('assets/img/asnaf-gorgan-default.jpg') }}">
                        <div class="archive-card-body">
                            <span class="card-cat">{{ $announcement->category?->title ?: 'اطلاعیه' }}</span>
                            <h2>{{ $announcement->title }}</h2>
                            <p>{{ $announcement->excerpt ?: Str::limit(strip_tags($announcement->body), 150) }}</p>
                            <span class="card-date">{{ jalali_date($announcement->published_at) }}</span>
                            @if ($announcement->union)<span class="card-date">{{ $announcement->union->name }}</span>@endif
                            @if ($announcement->is_important)<span class="card-date">مهم</span>@endif
                        </div>
                    </a>
                </article>
            @empty
                <p class="text-center">اطلاعیه‌ای با معیارهای انتخاب‌شده یافت نشد.</p>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $announcements->links() }}
        </div>
    </div>
</main>
@endsection
