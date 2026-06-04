@php
    $settings = app(\App\Services\SettingService::class);
    $footerLinksVariant = trim($__env->yieldContent('footer_links_variant', 'full')) ?: 'full';
    $footerLogo = $settings->get('footer.footer_logo') ?: $settings->get('site.site_logo');
    $footerLogoUrl = $footerLogo ? Storage::url($footerLogo) : asset('assets/img/asnaf-footer-mark.svg');
    $footerDescription = $settings->get('footer.footer_description', 'اتاق اصناف شهرستان گرگان به عنوان نماینده جامعه صنفی شهرستان، پشتیبان کسب‌وکارهای صنفی، ناظر بر فعالیت اتحادیه‌های صنفی و تسهیل‌گر تعامل با دستگاه‌های اجرایی و نظارتی در راستای توسعه اقتصاد شهری می‌باشد.');
    $footerColumns = $settings->get('footer.footer_columns', []);
    $contactInfo = $settings->get('footer.footer_contact_info', []);
    $socialLinks = $settings->get('footer.footer_social_links', $settings->get('site.social_links', []));
    $copyright = $settings->get('footer.copyright_text', 'تمام حقوق مادی و معنوی این وبسایت متعلق به اتاق اصناف شهرستان گرگان می‌باشد');
    $fallbackContact = [
        ['icon' => '📍', 'text' => $settings->get('site.address', 'گرگان، خیابان مطهری جنوبی، روبروی پمپ بنزین، ساختمان اتاق اصناف')],
        ['icon' => '📞', 'text' => $settings->get('site.phone', '۰۱۷-۳۲۱۵۲۹۱۲')],
        ['icon' => '✉️', 'text' => $settings->get('site.email', 'info@asnaf-gorgan.ir')],
    ];
@endphp
<footer class="site-footer"><div class="site-container"><div class="footer-main">
<div class="footer-col footer-brand-col"><img alt="{{ $settings->get('site.site_title', 'اتاق اصناف شهرستان گرگان') }}" src="{{ $footerLogoUrl }}"/><p>{{ $footerDescription }}</p></div>
@if(!empty($footerColumns))
    @foreach($footerColumns as $column)
        <div class="footer-col"><h4>{{ $column['title'] ?? 'لینک‌ها' }}</h4><ul>@foreach(($column['links'] ?? []) as $link)<li><a href="{{ $link['url'] ?? '#' }}">{{ $link['title'] ?? 'لینک' }}</a></li>@endforeach</ul></div>
    @endforeach
@else
<div class="footer-col"><h4>دسترسی سریع</h4><ul><li><a href="{{ route('home') }}">صفحه اصلی</a></li><li><a href="{{ route('posts.index') }}">آرشیو اخبار</a></li><li><a href="{{ route('guilds.index') }}">اتحادیه‌های صنفی</a></li>@if ($footerLinksVariant === 'full' || $footerLinksVariant === 'gallery-detail')<li><a href="{{ route('systems.index') }}">سامانه خدمات صنفی</a></li>@endif<li><a href="{{ route('galleries.index') }}">گالری تصاویر</a></li>@if ($footerLinksVariant !== 'gallery-detail')<li><a href="{{ route('tourism.index') }}">گردشگری</a></li>@endif<li><a href="{{ route('home') }}#friendship">تماس با ما</a></li></ul></div>
@endif
<div class="footer-col"><h4>اطلاعات تماس</h4>@foreach(($contactInfo ?: $fallbackContact) as $item)<div class="footer-contact-item"><span class="fc-icon">{{ $item['icon'] ?? '•' }}</span><span>{!! nl2br(e($item['text'] ?? '')) !!}</span></div>@endforeach</div>
</div><div class="footer-divider"></div>
<div class="footer-orgs"><a href="{{ route('home') }}">اتاق اصناف شهرستان گرگان</a><a href="#">اتاق اصناف ایران</a><a href="{{ route('systems.index') }}">سامانه نوین اصناف</a><a href="{{ route('commissions.index') }}">کمیسیون‌ها</a><a href="{{ route('posts.index') }}">فرم‌ها و بخشنامه‌ها</a></div>
<div class="footer-divider"></div><div class="footer-bottom"><div class="footer-social">@forelse($socialLinks as $link)<a href="{{ $link['url'] ?? '#' }}" aria-label="{{ $link['title'] ?? 'شبکه اجتماعی' }}" target="_blank" rel="noopener">{{ $link['icon'] ?? '🔗' }}</a>@empty<a href="#" aria-label="اینستاگرام">📷</a><a href="#" aria-label="تلگرام">✈️</a><a href="#" aria-label="واتساپ">💬</a>@endforelse</div><div class="footer-copy">{{ $copyright }}</div></div>
</div></footer>
