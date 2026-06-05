@if (($importantPosts ?? collect())->isNotEmpty())
<section class="representatives-section section-white">
    <div class="site-container">
        <div class="section-heading"><h2>{{ $section->title }}</h2><a class="tab-pill" href="{{ route('posts.index') }}">همه اخبار</a></div>
        <div class="archive-grid">
            @foreach ($importantPosts as $post)
                <article class="archive-card"><a href="{{ route('posts.show', $post->slug) }}"><img class="archive-card-img" src="{{ $post->featured_image ? Storage::url($post->featured_image) : asset('assets/img/asnaf-gorgan-default.jpg') }}" alt="{{ $post->title }}"><div class="archive-card-body"><span class="card-cat">{{ $post->category?->title ?: 'خبر' }}</span><h2>{{ $post->title }}</h2><p>{{ $post->excerpt ?: Str::limit(strip_tags($post->body), 120) }}</p></div></a></article>
            @endforeach
        </div>
    </div>
</section>
@endif
