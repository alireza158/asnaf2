@php
    $settings = app(\App\Services\SettingService::class);
    $footerItems = app(\App\Services\MenuService::class)->items('footer');
    $logo = $settings->get('footer.footer_logo', $settings->get('footer.logo', 'assets/img/asnaf-footer-mark.svg'));
    $description = $settings->get('footer.footer_description', $settings->get('footer.description', 'اتاق اصناف مرکز استان گلستان به عنوان نماینده جامعه صنفی شهرستان، پشتیبان کسب‌وکارهای صنفی، ناظر بر فعالیت اتحادیه‌های صنفی و تسهیل‌گر تعامل با دستگاه‌های اجرایی و نظارتی در راستای توسعه اقتصاد شهری می‌باشد. این اتاق با هدف حمایت از حقوق صنوف، ارتقای کیفیت خدمات و تسهیل فرآیندهای کسب‌وکار در سطح شهرستان گرگان فعالیت می‌نماید.'));
    $phone = $settings->get('site.phone', '۰۱۷-۳۲۱۵۲۹۱۲<br/>۰۱۷-۳۲۱۵۴۷۶۷');
    $address = $settings->get('site.address', 'گرگان، خیابان مطهری جنوبی، روبروی پمپ بنزین، ساختمان اتاق اصناف');
    $email = $settings->get('site.email', 'info@asnaf-gorgan.ir');
    $copyright = $settings->get('footer.copyright', 'تمام حقوق مادی و معنوی این وبسایت متعلق به اتاق اصناف مرکز استان گلستان می‌باشد');
    $socials = $settings->get('footer.social_links', []);
    $quickFallbacks = collect([
        ['title' => 'صفحه اصلی', 'url' => route('home')],
        ['title' => 'آرشیو اخبار', 'url' => route('posts.index')],
        ['title' => 'اتحادیه‌های صنفی', 'url' => route('guilds.index')],
        ['title' => 'سامانه خدمات صنفی', 'url' => route('systems.index')],
        ['title' => 'گالری تصاویر', 'url' => route('galleries.index')],
        ['title' => 'گردشگری', 'url' => route('tourism.index')],
        ['title' => 'چندرسانه‌ای', 'url' => '#multimedia'],
        ['title' => 'تماس با ما', 'url' => '#friendship'],
    ]);
    $orgFallbacks = collect([
        ['title' => 'اتاق اصناف مرکز استان گلستان', 'url' => route('home')],
        ['title' => 'اتاق اصناف ایران', 'url' => '#'],
        ['title' => 'سامانه نوین اصناف', 'url' => route('systems.index')],
        ['title' => 'سامانه آموزش اصناف', 'url' => route('electronic-services.index')],
        ['title' => 'اداره صمت گلستان', 'url' => '#'],
        ['title' => 'کمیسیون نظارت', 'url' => route('commissions.index')],
        ['title' => 'تعزیرات حکومتی', 'url' => '#'],
        ['title' => 'شهرداری گرگان', 'url' => '#'],
        ['title' => 'سازمان بازرسی', 'url' => route('complaints.create')],
        ['title' => 'فرم‌ها و بخشنامه‌ها', 'url' => route('announcements.index')],
    ]);
@endphp
<footer class="site-footer">
<div class="site-container">
<div class="footer-main">
<div class="footer-col footer-brand-col">
<img alt="اتاق اصناف مرکز استان گلستان" src="{{ asset($logo) }}"/>
<div>{!! $description !!}</div>
</div>
<div class="footer-col">
<h4>دسترسی سریع</h4>
<ul>
@forelse($footerItems->take(8) as $item)
<li><a href="{{ $item->resolved_url }}" target="{{ $item->target }}">{{ $item->title }}</a></li>
@empty
@foreach($quickFallbacks as $item)
<li><a href="{{ $item['url'] }}">{{ $item['title'] }}</a></li>
@endforeach
@endforelse
</ul>
</div>
<div class="footer-col">
<h4>اطلاعات تماس</h4>
<div class="footer-contact-item"><span class="fc-icon">📍</span><span>{{ $address }}</span></div>
<div class="footer-contact-item"><span class="fc-icon">📞</span><span>{!! $phone !!}</span></div>
<div class="footer-contact-item"><span class="fc-icon">✉️</span><span>{{ $email }}</span></div>
</div>
</div>
<div class="footer-divider"></div>
<div class="footer-orgs">
@forelse($footerItems->take(10) as $item)
<a href="{{ $item->resolved_url }}" target="{{ $item->target }}">{{ $item->title }}</a>
@empty
@foreach($orgFallbacks as $item)
<a href="{{ $item['url'] }}">{{ $item['title'] }}</a>
@endforeach
@endforelse
</div>
<div class="footer-divider"></div>
<div class="footer-bottom">
<div class="footer-social">
@forelse($socials as $label => $link)
<a href="{{ filled($link) ? $link : '#' }}" aria-label="{{ $label }}">{{ mb_substr((string) $label, 0, 1) }}</a>
@empty
<a href="#" aria-label="اینستاگرام">📷</a>
<a href="#" aria-label="تلگرام">✈️</a>
<a href="#" aria-label="واتساپ">💬</a>
<a href="#" aria-label="ایتا">📱</a>
<a href="#" aria-label="بله">🔵</a>
<a href="#" aria-label="روبیکا">🟣</a>
@endforelse
</div>
<div class="footer-copy">{{ $copyright }}</div>
</div>
</div>
</footer>
