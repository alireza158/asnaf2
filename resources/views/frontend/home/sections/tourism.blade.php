<section class="tourism-section" id="tourism">
    <div class="site-container">
        <div class="section-heading"><h2>{{ $section->title }}</h2><a class="tab-pill" href="{{ route('tourism.index') }}">مشاهده گردشگری</a></div>
        <div class="tourism-grid">
            @foreach ([['طبیعت','جنگل النگدره','یکی از زیباترین جاذبه‌های طبیعی استان گلستان'],['تاریخی','برج گنبد قابوس','میراث جهانی یونسکو در استان گلستان'],['خرید','بازار بزرگ گرگان','مرکز خرید اصیل و سنتی گرگان'],['اقامت','مرکز خرید گلستان','مجتمع تجاری مدرن با خدمات رفاهی']] as [$badge, $title, $text])
                <div class="tourism-card"><a href="{{ route('tourism.index') }}"><div class="tourism-img-wrap"><img alt="{{ $title }}" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}"/><div class="tourism-badge">{{ $badge }}</div></div><div class="tourism-card-body"><h3>{{ $title }}</h3><p>{{ $text }}</p></div></a></div>
            @endforeach
        </div>
    </div>
</section>
