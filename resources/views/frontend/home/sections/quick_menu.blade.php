@if (($quickMenuItems ?? collect())->isNotEmpty())
<section class="site-container my-4">
    <aside aria-label="{{ $section->title }}" class="quick-menu" style="position:relative;width:100%">
        <ul class="quick-menu-list">
            @foreach ($quickMenuItems as $item)
                <li class="quick-menu-item {{ $item->children->isNotEmpty() ? 'has-submenu' : '' }}">
                    @if ($item->children->isNotEmpty())
                        <button aria-expanded="false" class="quick-menu-link" type="button"><span>{{ $item->icon }} {{ $item->title }}</span><b></b></button>
                        <ul class="quick-submenu">
                            @foreach ($item->children as $child)
                                <li><a href="{{ $child->resolved_url }}" target="{{ $child->target }}" @if($child->target === '_blank') rel="noopener" @endif>{{ $child->icon }} {{ $child->title }}</a></li>
                            @endforeach
                        </ul>
                    @else
                        <a class="quick-menu-link" href="{{ $item->resolved_url }}" target="{{ $item->target }}" @if($item->target === '_blank') rel="noopener" @endif><span>{{ $item->icon }} {{ $item->title }}</span><b></b></a>
                    @endif
                </li>
            @endforeach
        </ul>
    </aside>
</section>
@endif
