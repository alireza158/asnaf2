<section class="hero-section site-container">
    <div class="hero-grid" style="grid-template-columns:1fr">
        <div aria-label="اسلایدر خبرهای اصلی" class="hero-slider swiper" dir="ltr">
            <div class="swiper-wrapper">
                @forelse (($heroPosts ?? $importantPosts ?? collect()) as $post)
                    <article class="news-card news-card-main swiper-slide">
                        <a href="{{ route('posts.show', $post->slug) }}">
                            <img alt="{{ $post->title }}" src="{{ $post->featured_image ? Storage::url($post->featured_image) : asset('assets/img/asnaf-gorgan-default.jpg') }}"/>
                            <div class="news-overlay"></div>
                            <div class="news-content"><span class="news-kicker">{{ $post->category?->title ?: 'خبر مهم' }}</span><h1>{{ $post->title }}</h1></div>
                        </a>
                    </article>
                @empty
                    <article class="news-card news-card-main swiper-slide">
                        <img alt="اتاق اصناف شهرستان گرگان" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/>
                        <div class="news-overlay"></div>
                        <div class="news-content"><span class="news-kicker">{{ $section->title }}</span><h1>{{ $section->subtitle ?: 'اطلاع‌رسانی خدمات صنفی، آموزش و پیگیری درخواست‌های کسب‌وکارهای شهرستان گرگان' }}</h1></div>
                    </article>
                @endforelse
            </div>
            <button aria-label="خبر بعدی" class="hero-slider-arrow hero-slider-next" type="button"></button>
            <button aria-label="خبر قبلی" class="hero-slider-arrow hero-slider-prev" type="button"></button>
            <div class="hero-slider-pagination"></div>
        </div>
    </div>
</section>
