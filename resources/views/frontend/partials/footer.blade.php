@php
    $settings = app(\App\Services\SettingService::class);
    $footerItems = app(\App\Services\MenuService::class)->items('footer');
    $logo = $settings->get('footer.logo', 'assets/img/asnaf-footer-mark.svg');
    $description = $settings->get('footer.description', 'اتاق اصناف شهرستان گرگان به عنوان نماینده جامعه صنفی شهرستان، پشتیبان کسب‌وکارهای صنفی، ناظر بر فعالیت اتحادیه‌های صنفی و تسهیل‌گر تعامل با دستگاه‌های اجرایی و نظارتی در راستای توسعه اقتصاد شهری می‌باشد.');
    $phone = $settings->get('site.phone', '۰۱۷-۳۲۱۵۲۹۱۲');
    $address = $settings->get('site.address', 'گرگان، خیابان مطهری جنوبی، ساختمان اتاق اصناف');
    $email = $settings->get('site.email', 'info@asnaf-gorgan.ir');
    $copyright = $settings->get('footer.copyright', 'تمام حقوق مادی و معنوی این وبسایت متعلق به اتاق اصناف شهرستان گرگان می‌باشد');
    $socials = $settings->get('footer.social_links', []);
@endphp
<footer class="site-footer">
<div class="site-container">
<div class="footer-main">
<div class="footer-col footer-brand-col">
<img alt="اتاق اصناف شهرستان گرگان" src="{{ asset($logo) }}"/>
<p>{{ $description }}</p>
</div>
<div class="footer-col">
<h4>دسترسی سریع</h4>
<ul>
@forelse($footerItems as $item)
<li><a href="{{ $item->resolved_url }}" target="{{ $item->target }}">{{ $item->title }}</a></li>
@empty
<li><a href="{{ route('home') }}">صفحه اصلی</a></li>
<li><a href="{{ route('posts.index') }}">آرشیو اخبار</a></li>
<li><a href="{{ route('guilds.index') }}">اتحادیه‌های صنفی</a></li>
<li><a href="{{ route('systems.index') }}">سامانه خدمات صنفی</a></li>
<li><a href="{{ route('galleries.index') }}">گالری تصاویر</a></li>
<li><a href="{{ route('tourism.index') }}">گردشگری</a></li>
<li><a href="{{ route('contact.create') }}">تماس با ما</a></li>
@endforelse
</ul>
</div>
<div class="footer-col">
<h4>اطلاعات تماس</h4>
<div class="footer-contact-item"><span class="fc-icon">📍</span><span>{{ $address }}</span></div>
<div class="footer-contact-item"><span class="fc-icon">📞</span><span>{{ $phone }}</span></div>
<div class="footer-contact-item"><span class="fc-icon">✉️</span><span>{{ $email }}</span></div>
</div>
</div>
<div class="footer-divider"></div>
<div class="footer-orgs">
@forelse($footerItems->skip(0)->take(10) as $item)
<a href="{{ $item->resolved_url }}" target="{{ $item->target }}">{{ $item->title }}</a>
@empty
<a href="{{ route('home') }}">اتاق اصناف شهرستان گرگان</a><a href="{{ route('systems.index') }}">سامانه نوین اصناف</a><a href="{{ route('commissions.index') }}">کمیسیون نظارت</a>
@endforelse
</div>
<div class="footer-divider"></div>
<div class="footer-bottom">
<div class="footer-social">
@forelse($socials as $label => $link)
<a href="{{ $link }}" aria-label="{{ $label }}">{{ mb_substr((string) $label, 0, 1) }}</a>
@empty
<a href="#" aria-label="اینستاگرام">📷</a>
<a href="#" aria-label="تلگرام">✈️</a>
<a href="#" aria-label="واتساپ">💬</a>
@endforelse
</div>
<div class="footer-copy">{{ $copyright }}</div>
</div>
</div>
</footer>
