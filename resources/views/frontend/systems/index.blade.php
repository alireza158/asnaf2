@extends('frontend.layouts.app')

@section('title', 'سامانه‌ها | اتاق اصناف مرکز استان گلستان')
@section('meta_description', 'لیست سامانه‌های پرکاربرد صنفی، خدمات الکترونیک و درگاه‌های مرتبط با اتاق اصناف مرکز استان گلستان')
@section('frontend_variant', 'compact')
@section('footer_links_variant', 'short')

@section('content')
<section class="page-header page-header-alt">
  <div class="site-container">
    <h1>سامانه‌ها</h1>
    <nav class="breadcrumb">
      <a href="{{ route('home') }}">خانه</a>
      <span>سامانه‌ها</span>
    </nav>
  </div>
</section>

<section class="site-container">
  <div class="section-heading section-heading-centered">
    <h2>لیست سامانه‌های صنفی</h2>
    <p>دسترسی سریع به سامانه‌ها و درگاه‌های پرکاربرد مرتبط با اصناف</p>
  </div>

  <form class="archive-filters mb-4" action="{{ route('systems.index') }}" method="GET">
    @if ($activeCategory !== '')<input type="hidden" name="category" value="{{ $activeCategory }}">@endif
    <input class="form-control" name="search" value="{{ $search }}" placeholder="جستجو در سامانه‌ها..." type="search">
    <button class="tab-pill active" type="submit">جستجو</button>
    @if ($search !== '' || $activeCategory !== '')<a class="tab-pill" href="{{ route('systems.index') }}">نمایش همه</a>@endif
  </form>

  <div class="tourism-tabs" aria-label="فیلتر دسته‌بندی سامانه‌ها">
    <a class="tab-pill {{ $activeCategory === '' ? 'active' : '' }}" href="{{ route('systems.index', array_filter(['search' => $search])) }}">همه سامانه‌ها</a>
    @foreach ($categories as $category)
      <a class="tab-pill {{ $activeCategory === $category->slug || $activeCategory === (string) $category->id ? 'active' : '' }}" href="{{ route('systems.index', array_filter(['category' => $category->slug, 'search' => $search])) }}">{{ $category->title }}</a>
    @endforeach
  </div>

  <div class="fraction-grid mt-4">
    @forelse ($systems as $system)
      <div class="fraction-link" style="text-align:right">
        <a href="{{ route('systems.show', $system->slug) }}" style="text-decoration:none;color:inherit">
          <div style="font-size:2rem;margin-bottom:10px">{{ $system->icon ?: '💻' }}</div>
          <h3>{{ $system->title }}</h3>
          <p>{{ Str::limit($system->short_description ?: strip_tags($system->description), 110) ?: 'توضیحات این سامانه به‌زودی تکمیل می‌شود.' }}</p>
        </a>
        <div class="mt-3 d-flex gap-2">
          <a class="tab-pill" href="{{ route('systems.show', $system->slug) }}">جزئیات</a>
          @if ($system->link)<a class="tab-pill active" href="{{ $system->link }}" target="{{ $system->target }}" @if($system->target === '_blank') rel="noopener" @endif>ورود به سامانه</a>@endif
        </div>
      </div>
    @empty
      <p class="text-muted text-center">سامانه فعالی برای نمایش یافت نشد.</p>
    @endforelse
  </div>

  <div class="mt-4">{{ $systems->links() }}</div>
</section>
@endsection
