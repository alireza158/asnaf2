<section class="site-container my-4">
    <aside aria-label="{{ $section->title }}" class="quick-menu" style="position:relative;width:100%">
        <ul class="quick-menu-list">
            @foreach ([
                ['درباره اتاق اصناف', ['معرفی اتاق اصناف گرگان', 'هیئت رئیسه و ساختار اداری', 'شرح وظایف و اختیارات']],
                ['خدمات متقاضیان', ['راهنمای صدور پروانه کسب', 'تمدید و انتقال پروانه', 'پیگیری درخواست‌ها']],
                ['اتحادیه‌های صنفی', ['فهرست اتحادیه‌های گرگان', 'اطلاعات تماس اتحادیه‌ها', 'رسته‌های شغلی']],
                ['بازرسی و نظارت', ['ثبت شکایت صنفی', 'گزارش تخلف', 'پیگیری بازرسی‌ها']],
                ['سامانه‌ها', ['سامانه نوین اصناف', 'سامانه آموزش اصناف', 'فرم‌ها و درخواست‌ها']],
            ] as [$title, $items])
                <li class="quick-menu-item has-submenu">
                    <button aria-expanded="false" class="quick-menu-link" type="button"><span>{{ $title }}</span><b></b></button>
                    <ul class="quick-submenu">@foreach ($items as $item)<li><a href="#">{{ $item }}</a></li>@endforeach</ul>
                </li>
            @endforeach
        </ul>
    </aside>
</section>
