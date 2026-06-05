@php
    $imageUrl = fn ($path) => $path ? (Str::startsWith($path, ['http://', 'https://', '/', 'assets/']) ? (Str::startsWith($path, 'assets/') ? asset($path) : $path) : Storage::url($path)) : asset('assets/img/asnaf-gorgan-default.jpg');
@endphp
<section class="home-ad-banners site-container mid-ad">
    @forelse ($homeAdvertisements ?? collect() as $advertisement)
        <a class="ad-banner" href="{{ filled($advertisement->link) && $advertisement->link !== '#' ? $advertisement->link : route('contact.create') }}" target="{{ $advertisement->target }}" @if($advertisement->target === '_blank') rel="noopener" @endif>
            <img alt="{{ $advertisement->title }}" src="{{ $imageUrl($advertisement->image) }}" loading="lazy"/>
            <div class="ad-banner-overlay"></div>
            <div class="ad-banner-text">{{ $advertisement->title }}</div>
        </a>
    @empty
        <a class="ad-banner" href="{{ route('contact.create') }}">
            <img alt="فضای تبلیغات" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}" loading="lazy"/>
            <div class="ad-banner-overlay"></div>
            <div class="ad-banner-text">برای ثبت تبلیغات با اتاق اصناف تماس بگیرید</div>
        </a>
    @endforelse
</section>
