<section class="site-container howto-section">
    <div class="section-heading section-heading-centered"><h2>{{ $section->title }}</h2><p>{{ $section->subtitle }}</p></div>
    <div class="howto-grid">
        @foreach ([['📋','نحوه صدور پروانه کسب','راهنمای گام‌به‌گام دریافت پروانه کسب جدید'],['🔄','نحوه تمدید پروانه کسب','مراحل تمدید سالانه پروانه کسب و مدارک مورد نیاز'],['⚖️','ثبت شکایت صنفی','ثبت و پیگیری شکایات مردمی و گزارش تخلف'],['📁','فرم‌ها و بخشنامه‌ها','دسترسی به فرم‌های اداری و بخشنامه‌های جاری'],['💻','سامانه نوین اصناف','ورود به سامانه الکترونیک اصناف'],['🎓','آموزش احکام تجارت','ثبت‌نام در دوره‌های آموزشی مورد نیاز']] as [$icon, $title, $text])
            <a class="howto-card" href="#"><div class="howto-icon">{{ $icon }}</div><h3>{{ $title }}</h3><p>{{ $text }}</p><span class="howto-link">مشاهده ←</span></a>
        @endforeach
    </div>
</section>
