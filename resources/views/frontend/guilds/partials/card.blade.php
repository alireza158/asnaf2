<article class="archive-card guild-card">
    <a href="{{ route('guilds.show', $union->slug) }}">
        <img alt="{{ $union->display_title }}" class="archive-card-img" src="{{ $assetImage($union->cover_image) }}">
        <div class="archive-card-body">
            <span class="card-cat">{{ $union->category?->title ?: $union->union_type_label }}</span>
            <h2>{{ $union->display_title }}</h2>
            <p>{{ $union->short_description ?: Str::limit(strip_tags($union->description), 150) }}</p>
            @if ($union->manager_name)<span class="card-date">مدیر: {{ $union->manager_name }}</span>@endif
            @if ($union->phone)<span class="card-date">{{ fa_number($union->phone) }}</span>@endif
        </div>
    </a>
</article>
