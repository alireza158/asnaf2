@php
    $imageUrl = fn ($path) => $path ? (Str::startsWith($path, ['http://', 'https://', '/', 'assets/']) ? (Str::startsWith($path, 'assets/') ? asset($path) : $path) : Storage::url($path)) : asset('assets/img/asnaf-gorgan-default.jpg');
@endphp
<section class="representatives-section section-white" id="representatives">
    <div class="site-container">
        <div class="section-heading"><h2>{{ $section->title }}</h2><a class="tab-pill" href="{{ route('guilds.index') }}">فهرست اتحادیه‌ها</a></div>
        <div class="archive-grid">
            @forelse ($homeUnions ?? collect() as $union)
                <article class="archive-card"><a href="{{ route('guilds.show', $union->slug) }}"><img class="archive-card-img" src="{{ $imageUrl($union->cover_image) }}" alt="{{ $union->display_title }}" loading="lazy"><div class="archive-card-body"><span class="card-cat">اتحادیه صنفی</span><h2>{{ $union->display_title }}</h2><p>{{ $union->short_description ?: Str::limit(strip_tags($union->description), 120) }}</p></div></a></article>
            @empty
                <article class="archive-card"><a href="{{ route('guilds.index') }}"><img class="archive-card-img" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="موردی موجود نیست" loading="lazy"><div class="archive-card-body"><span class="card-cat">اتحادیه صنفی</span><h2>موردی موجود نیست</h2><p>در حال حاضر اتحادیه‌ای برای نمایش در صفحه اصلی ثبت نشده است.</p></div></a></article>
            @endforelse
        </div>
    </div>
</section>
