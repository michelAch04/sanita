@if ($paginator->hasPages())
<nav class="d-flex justify-items-center justify-content-between mt-4">
    <div class="justify-content-between flex-fill d-none">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link">@lang('pagination.previous')</span>
            </li>
            @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>
            </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
            </li>
            @else
            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link">@lang('pagination.next')</span>
            </li>
            @endif
        </ul>
    </div>

    <div class="flex-fill d-flex align-items-center justify-content-between flex-column">
        <div class="order-last">
            <p class="small text-muted">
                {!! __('Showing') !!}
                <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                -
                <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                {!! __('of') !!}
                <span class="fw-semibold">{{ $paginator->total() }}</span>
                {!! __('results') !!}
            </p>
        </div>

        <div>
            <ul class="pagination d-flex justify-content-center align-items-center">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                <li class="page-item disabled arrow" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
                @else
                <li class="page-item arrow">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                <li class="page-item active m-0" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                @else
                <li class="page-item m-0"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endif
                @endforeach
                @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                <li class="page-item arrow ">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
                @else
                <li class="page-item disabled arrow" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<style>
    .pagination .page-link {
        position: relative;
        overflow: hidden;
        font-size: 1.25rem;
        border-radius: 0.5rem;
        background: none;
        border: none;
        color: var(--primary-text);
        transition: color 0.3s;
    }

    .pagination .page-link:active,
    .pagination .page-link:focus {

        box-shadow: none;
    }


    .pagination .page-link::after {
        content: '';
        display: inline-block;
        position: absolute;
        left: 50%;
        bottom: 0.2em;
        height: 2px;
        width: 0;
        background: var(--link-hover);
        transition: width 0.3s cubic-bezier(.4, 0, .2, 1);
        transform: translateX(-50%);
    }

    .pagination .page-link:hover::after,
    .pagination .page-item.active .page-link::after {
        width: 50%;
        /* Adjust this value for how much of the text you want underlined */
    }

    .pagination .page-item.active .page-link {
        color: var(--secondary-blue);
        text-decoration: none;
    }

    .pagination .page-item.active .page-link::after {
        background: var(--secondary-blue);
    }

    .pagination .page-link:hover {
        color: var(--link-hover);
    }

    .pagination .arrow .page-link {
        font-size: 2rem !important;
        /* Larger arrow size */
        font-weight: 700;
        /* Make arrows bold */
        text-decoration: none;
    }

    .pagination .arrow .page-link::after {
        display: none;
        /* Remove underline for arrows */
    }

    .pagination .page-item {
        margin: 0 0.15rem;
        /* Add horizontal spacing between page items */
    }

    /* Optional: enlarge the "Showing x-y of z results" text */
    .order-last p.small.text-muted {
        font-size: 1rem;
    }

    @media (max-width: 768px) {
        .pagination .page-link {
            font-size: 1rem;
            /* Reduce font size on smaller screens */
        }

        .pagination .arrow .page-link {
            font-size: 1.5rem !important;
            /* Slightly smaller arrows */
        }

        .pagination .page-item {
            margin: 0 0.1rem;
            /* Tighter spacing between items */
        }

        .order-last p.small.text-muted {
            font-size: 0.85rem;
            /* Smaller "Showing x–y of z results" text */
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .pagination .page-link {
            font-size: 0.9rem;
            padding: 0.25rem 0.5rem;
        }

        .pagination .arrow .page-link {
            font-size: 1.25rem !important;
        }

        .order-last p.small.text-muted {
            font-size: 0.75rem;
        }
        
        .list-pagination {
            margin: 0 !important;
        }

        .pagination {
            margin: 0.1rem !important;
        }
    }
</style>
@endif