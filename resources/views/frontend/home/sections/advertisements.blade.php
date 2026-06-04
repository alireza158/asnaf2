@php($advertisements = app(\App\Services\AdvertisementService::class)->getByPosition('home_top'))

<section class="home-ad-banners site-container mid-ad">
    @forelse ($advertisements as $advertisement)
        <a class="ad-banner" href="{{ $advertisement->link ?: '#' }}" target="{{ $advertisement->target }}" @if($advertisement->target === '_blank') rel="noopener" @endif>
            <img alt="{{ $advertisement->title }}" src="{{ Storage::url($advertisement->image) }}" loading="lazy"/>
            <div class="ad-banner-overlay"></div>
            <div class="ad-banner-text">{{ $advertisement->title }}</div>
        </a>
    @empty
        @foreach ([1, 2] as $i)
            <a class="ad-banner" href="#"><img alt="تبلیغات" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/><div class="ad-banner-overlay"></div><div class="ad-banner-text">{{ $section->content ?: 'فضای تبلیغات شما' }}</div></a>
        @endforeach
    @endforelse
</section>
