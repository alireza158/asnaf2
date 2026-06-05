@if (($homeAdvertisements ?? collect())->isNotEmpty())
<section class="home-ad-banners site-container mid-ad">
    @foreach ($homeAdvertisements as $advertisement)
        <a class="ad-banner" href="{{ filled($advertisement->link) && $advertisement->link !== '#' ? $advertisement->link : '#' }}" target="{{ $advertisement->target }}" @if($advertisement->target === '_blank') rel="noopener" @endif>
            <img alt="{{ $advertisement->title }}" src="{{ Storage::url($advertisement->image) }}" loading="lazy"/>
            <div class="ad-banner-overlay"></div>
            <div class="ad-banner-text">{{ $advertisement->title }}</div>
        </a>
    @endforeach
</section>
@endif
