@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <h2>
            </h2>
        @else
            <h2><a href="{{ $paginator->previousPageUrl() }}" rel="prev">
                {!! __('pagination.previous') !!}
            </a></h2>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <h2><a href="{{ $paginator->nextPageUrl() }}" rel="next">
                {!! __('pagination.next') !!}
            </a></h2>
        @else
            <h2>
            </h2>
        @endif
    </nav>
@endif
