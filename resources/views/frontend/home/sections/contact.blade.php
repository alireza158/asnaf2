<section class="friendship-section section-white" id="contact">
    <div class="site-container">
        <div class="section-heading friendship-heading"><h2>{{ $section->title }}</h2><a class="tab-pill" href="#">راهنمای تماس</a></div>
        <div class="friendship-layout">
            <div class="world-map-wrap"><img alt="اتاق اصناف شهرستان گرگان" class="world-map-img" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/></div>
            <aside class="friend-list"><div class="friend-scroll-wrap"><ul>
                @foreach (['اتاق اصناف شهرستان گرگان؛ خیابان مطهری جنوبی، روبروی پمپ بنزین، ساختمان اتاق اصناف', 'تلفن‌های ثبت‌شده: ۰۱۷۳۲۱۵۲۹۱۲ و ۰۱۷۳۲۱۵۴۷۶۷', 'پیگیری امور اتحادیه‌ها و رسته‌های شغلی شهرستان گرگان', 'ثبت و پیگیری شکایات، گزارش تخلف و امور بازرسی بازار', 'اطلاع‌رسانی دوره‌های آموزش احکام تجارت و کسب‌وکار'] as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul></div></aside>
        </div>
    </div>
</section>
