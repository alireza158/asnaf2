@php
    $settings = app(\App\Services\SettingService::class);
    $footerLogo = $settings->get('footer.footer_logo') ?: $settings->get('site.site_logo');
    $footerLogoUrl = $footerLogo ? Storage::url($footerLogo) : asset('assets/img/asnaf-footer-mark.svg');
    $footerDescription = $settings->get('footer.footer_description');
    $footerColumns = collect($settings->get('footer.footer_columns', []));
    $footerMenuItems = app(\App\Services\MenuService::class)->items('footer');
    $contactInfo = collect($settings->get('footer.footer_contact_info', []))->filter(fn ($item) => filled($item['text'] ?? null));
    $socialLinks = collect($settings->get('footer.footer_social_links', $settings->get('site.social_links', [])))->filter(fn ($link) => filled($link['url'] ?? null));
    $copyright = $settings->get('footer.copyright_text');
@endphp
<footer class="site-footer"><div class="site-container"><div class="footer-main">
<div class="footer-col footer-brand-col"><img alt="{{ $settings->get('site.site_title', 'اتاق اصناف شهرستان گرگان') }}" src="{{ $footerLogoUrl }}"/>@if($footerDescription)<p>{{ $footerDescription }}</p>@endif</div>
@if($footerColumns->isNotEmpty())
    @foreach($footerColumns as $column)
        @if(filled($column['title'] ?? null) || !empty($column['links'] ?? []))
            <div class="footer-col"><h4>{{ $column['title'] ?? 'لینک‌ها' }}</h4><ul>@foreach(($column['links'] ?? []) as $link)@if(filled($link['title'] ?? null))<li><a href="{{ $link['url'] ?? '#' }}">{{ $link['title'] }}</a></li>@endif @endforeach</ul></div>
        @endif
    @endforeach
@elseif($footerMenuItems->isNotEmpty())
    <div class="footer-col"><h4>دسترسی سریع</h4><ul>@foreach($footerMenuItems as $item)<li><a href="{{ $item->resolved_url }}" target="{{ $item->target }}" @if($item->target === '_blank') rel="noopener" @endif>{{ $item->icon }} {{ $item->title }}</a></li>@endforeach</ul></div>
@endif
@if($contactInfo->isNotEmpty())
<div class="footer-col"><h4>اطلاعات تماس</h4>@foreach($contactInfo as $item)<div class="footer-contact-item"><span class="fc-icon">{{ $item['icon'] ?? '•' }}</span><span>{!! nl2br(e($item['text'] ?? '')) !!}</span></div>@endforeach</div>
@endif
</div><div class="footer-divider"></div>
@if($footerColumns->isNotEmpty() && $footerMenuItems->isNotEmpty())
<div class="footer-orgs">@foreach($footerMenuItems as $item)<a href="{{ $item->resolved_url }}" target="{{ $item->target }}" @if($item->target === '_blank') rel="noopener" @endif>{{ $item->title }}</a>@endforeach</div>
<div class="footer-divider"></div>
@endif
<div class="footer-bottom">@if($socialLinks->isNotEmpty())<div class="footer-social">@foreach($socialLinks as $link)<a href="{{ $link['url'] }}" aria-label="{{ $link['title'] ?? 'شبکه اجتماعی' }}" target="_blank" rel="noopener">{{ $link['icon'] ?? '🔗' }}</a>@endforeach</div>@endif @if($copyright)<div class="footer-copy">{{ $copyright }}</div>@endif</div>
</div></footer>
