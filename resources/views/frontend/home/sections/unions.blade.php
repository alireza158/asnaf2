@if (($homeUnions ?? collect())->isNotEmpty())
<section class="representatives-section section-white" id="representatives">
    <div class="site-container">
        <div class="section-heading"><h2>{{ $section->title }}</h2><a class="tab-pill" href="{{ route('guilds.index') }}">فهرست اتحادیه‌ها</a></div>
        <div class="archive-grid">
            @foreach ($homeUnions as $union)
                <article class="archive-card"><a href="{{ route('guilds.show', $union->slug) }}"><img class="archive-card-img" src="{{ $union->cover_image ? Storage::url($union->cover_image) : asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="{{ $union->display_title }}"><div class="archive-card-body"><span class="card-cat">اتحادیه صنفی</span><h2>{{ $union->display_title }}</h2><p>{{ $union->short_description ?: Str::limit(strip_tags($union->description), 120) }}</p></div></a></article>
            @endforeach
        </div>
    </div>
</section>
@endif
