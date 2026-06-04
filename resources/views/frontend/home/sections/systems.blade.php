<section class="fractions-section section-gray" id="systems">
    <div class="site-container">
        <div class="section-heading"><h2>{{ $section->title }}</h2><p>{{ $section->subtitle }}</p></div>
        <div class="fraction-grid">
            @foreach (['سامانه نوین اصناف', 'سامانه آموزش اصناف', 'درگاه ملی مجوزها', 'سامانه شکایات', 'استعلام پروانه کسب', 'فرم‌ها و درخواست‌ها'] as $item)
                <a href="#" class="fraction-link">{{ $item }}</a>
            @endforeach
        </div>
    </div>
</section>
