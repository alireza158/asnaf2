@if ($paginator->hasPages())
    <nav class="pagination-nav" aria-label="صفحه‌بندی">
        @if ($paginator->onFirstPage())
            <span class="disabled" aria-disabled="true">→</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev">→</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="disabled" aria-disabled="true">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="current" aria-current="page">{{ fa_number($page) }}</span>
                    @else
                        <a href="{{ $url }}">{{ fa_number($page) }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next">←</a>
        @else
            <span class="disabled" aria-disabled="true">←</span>
        @endif
    </nav>
@endif
