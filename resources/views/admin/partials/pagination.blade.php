@php
    /** @var \Illuminate\Contracts\Pagination\Paginator|\Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator */
@endphp

@if ($paginator->hasPages())
    <nav class="admin-pagination-wrapper" aria-label="صفحه‌بندی مدیریت" data-admin-pagination>
        @if (method_exists($paginator, 'firstItem'))
            <div class="admin-pagination-summary">
                نمایش {{ $paginator->firstItem() }} تا {{ $paginator->lastItem() }} از {{ $paginator->total() }} مورد
            </div>
        @endif

        <div class="admin-pagination-links">
            {{ $paginator->onEachSide(1)->links() }}
        </div>

        <div class="admin-pagination-fallback" aria-label="لینک‌های صفحه قبل و بعد">
            @if ($paginator->previousPageUrl())
                <a class="admin-secondary-btn" href="{{ $paginator->previousPageUrl() }}" data-url="{{ $paginator->previousPageUrl() }}" rel="prev">صفحه قبل</a>
            @else
                <span class="admin-secondary-btn is-disabled" aria-disabled="true">صفحه قبل</span>
            @endif

            @if ($paginator->nextPageUrl())
                <a class="admin-secondary-btn" href="{{ $paginator->nextPageUrl() }}" data-url="{{ $paginator->nextPageUrl() }}" rel="next">صفحه بعد</a>
            @else
                <span class="admin-secondary-btn is-disabled" aria-disabled="true">صفحه بعد</span>
            @endif
        </div>
    </nav>
@elseif (method_exists($paginator, 'total'))
    <div class="admin-pagination-wrapper admin-pagination-wrapper-empty">
        <div class="admin-pagination-summary">نمایش {{ $paginator->total() }} مورد</div>
    </div>
@endif
