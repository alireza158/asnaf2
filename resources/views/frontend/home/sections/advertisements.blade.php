<section class="home-ad-banners site-container mid-ad">
    @foreach ([1, 2] as $i)
        <a class="ad-banner" href="#"><img alt="تبلیغات" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/><div class="ad-banner-overlay"></div><div class="ad-banner-text">{{ $section->content ?: 'فضای تبلیغات شما' }}</div></a>
    @endforeach
</section>
