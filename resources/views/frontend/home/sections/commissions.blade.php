<section class="commissions-section ds-tint-block" id="commissions">
    <div class="site-container">
        <div class="section-heading"><h2>{{ $section->title }}</h2><p>{{ $section->subtitle }}</p></div>
        <div class="commission-card"><div class="commission-grid compact-grid">
            @foreach ([['صدور پروانه','ثبت، بررسی و راهنمای صدور پروانه کسب'],['تمدید پروانه','تمدید، تغییر نشانی و انتقال واحد صنفی'],['بازرسی','نظارت بر واحدهای صنفی و رعایت مقررات'],['شکایات','ثبت و پیگیری شکایات شهروندان'],['احکام تجارت','دوره‌های آموزشی متقاضیان پروانه کسب'],['اتحادیه‌ها','هماهنگی بین اتحادیه‌های صنفی شهرستان'],['اطلاع‌رسانی','خبرها و اطلاعیه‌های مهم اتاق'],['مشاوره صنفی','راهنمایی متقاضیان و مباشرین']] as $index => [$title, $text])
                <a class="commission-item {{ $index % 2 ? 'green' : 'blue' }}" href="#"><strong>{{ $title }}</strong><span>{{ $text }}</span></a>
            @endforeach
        </div></div>
    </div>
</section>
