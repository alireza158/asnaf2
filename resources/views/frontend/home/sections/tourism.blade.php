@if (($tourismPlaces ?? collect())->isNotEmpty())
<section class="tourism-section" id="tourism">
    <div class="site-container">
        <div class="section-heading"><h2>{{ $section->title }}</h2><a class="tab-pill" href="{{ route('tourism.index') }}">مشاهده گردشگری</a></div>
        <div class="tourism-grid">
            @foreach ($tourismPlaces as $place)
                <div class="tourism-card"><a href="{{ route('tourism.show', $place->slug) }}"><div class="tourism-img-wrap"><img alt="{{ $place->title }}" src="{{ $place->featured_image ? Storage::url($place->featured_image) : asset('assets/img/asnaf-gorgan-default.jpg') }}"/><div class="tourism-badge">{{ $place->category?->title ?: 'گردشگری' }}</div></div><div class="tourism-card-body"><h3>{{ $place->title }}</h3><p>{{ Str::limit($place->short_description ?: strip_tags($place->description), 100) }}</p></div></a></div>
            @endforeach
        </div>
    </div>
</section>
@endif
