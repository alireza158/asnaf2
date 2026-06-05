@extends('frontend.layouts.app')

@section('title', 'آرشیو اخبار | اتاق اصناف شهرستان گرگان')
@section('meta_description', 'آرشیو اخبار منتشرشده اتاق اصناف شهرستان گرگان با امکان جستجو و فیلتر بر اساس دسته‌بندی و اتحادیه')

@section('content')
<div class="page-header">
    <div class="site-container">
        <nav class="breadcrumb-nav">
            <a href="{{ route('home') }}">خانه</a>
            <span class="breadcrumb-sep">/</span>
            <span>آرشیو اخبار</span>
        </nav>
        <h1>آرشیو اخبار</h1>
    </div>
</div>

<main class="archive-page">
    <div class="site-container">
        <div class="archive-header">
            <h1>همه اخبار منتشرشده</h1>
        </div>

        <form class="archive-filters" action="{{ route('posts.index') }}" method="GET">
            <input class="form-control" name="search" value="{{ $search }}" placeholder="جستجو در اخبار..." type="search">
            <select class="form-control" name="category_id" aria-label="فیلتر دسته‌بندی">
                <option value="">همه دسته‌بندی‌ها</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) $categoryId === (string) $category->id)>{{ $category->title }}</option>
                @endforeach
            </select>
            <select class="form-control" name="union_id" aria-label="فیلتر اتحادیه">
                <option value="">همه اتحادیه‌ها و اخبار عمومی</option>
                @foreach ($unions as $union)
                    <option value="{{ $union->id }}" @selected((string) $unionId === (string) $union->id)>{{ $union->name }}</option>
                @endforeach
            </select>
            <button class="tab-pill active" type="submit">اعمال فیلتر</button>
            @if ($search !== '' || $categoryId || $unionId)
                <a class="tab-pill" href="{{ route('posts.index') }}">حذف فیلتر</a>
            @endif
        </form>

        <div class="archive-grid">
            @forelse ($posts as $post)
                <article class="archive-card">
                    <a href="{{ route('posts.show', $post->slug) }}">
                        <img alt="{{ $post->title }}" class="archive-card-img" src="{{ $post->featured_image ? Storage::url($post->featured_image) : asset('assets/img/asnaf-gorgan-default.jpg') }}">
                        <div class="archive-card-body">
                            <span class="card-cat">{{ $post->category?->title ?: 'اخبار' }}</span>
                            <h2>{{ $post->title }}</h2>
                            <p>{{ $post->excerpt ?: Str::limit(strip_tags($post->body), 150) }}</p>
                            <span class="card-date">{{ jalali_date($post->published_at) }}</span>
                            @if ($post->union)<span class="card-date">{{ $post->union->name }}</span>@endif
                        </div>
                    </a>
                </article>
            @empty
                <p class="text-center">خبری با معیارهای انتخاب‌شده یافت نشد.</p>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>
</main>
@endsection
