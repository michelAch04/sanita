@extends('sanita.layout')

@section('title', __('nav.pos_title') . ' — Sanita')

@section('content')
<div class="pos-page" dir="rtl">
    <div class="container my-4 px-3">

        <h2 class="display-5 text-center mb-4 section-title px-1">{{ __('nav.pos_title') }}</h2>

        {{-- City filter chips (only rendered if any location has a city assigned) --}}
        @if ($cityCounts->isNotEmpty())
        <div class="pos-filter-wrap mb-3">
            <a href="{{ request()->url() }}"
               class="pos-filter-chip {{ !$cityFilter ? 'active' : '' }}">
                {{ __('nav.all_subcategories') }}
            </a>
            @foreach ($cityCounts as $cc)
                @if ($cc->city)
                <a href="{{ request()->url() }}?city={{ $cc->cities_id }}"
                   class="pos-filter-chip {{ $cityFilter == $cc->cities_id ? 'active' : '' }}">
                    {{ $cc->city->{'name_' . app()->getLocale()} ?? $cc->city->name_ar ?? $cc->city->name_en }}
                    ({{ $cc->total }})
                </a>
                @endif
            @endforeach
        </div>
        @endif

        @if ($locations->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-geo-alt" style="font-size: 3rem; color: var(--primary-blue);"></i>
                <p class="mt-3 text-secondary">{{ __('nav.pos_no_locations') }}</p>
            </div>
        @else
            <div class="pos-grid">
                @foreach ($locations as $loc)
                <div class="pos-card bg-white p-2 d-flex flex-column gap-1">
                    <div class="d-flex align-items-center gap-1">
                        <i class="bi bi-geo-alt-fill pos-card-icon mt-1"></i>
                        <span class="pos-card-name">{{ $loc->name }}</span>
                    </div>
                    <p class="pos-card-address mb-0">{{ $loc->address }}</p>
                    @if ($loc->city && !$cityFilter)
                        <span class="pos-card-badge">
                            {{ $loc->city->{'name_' . app()->getLocale()} ?? $loc->city->name_ar ?? $loc->city->name_en }}
                        </span>
                    @endif
                </div>
                @endforeach
            </div>

            @if ($locations->hasPages())
            <div dir="ltr" class="d-flex justify-content-center list-pagination mt-3">
                {{ $locations->links('pagination::bootstrap-5') }}
            </div>
            @endif
        @endif

    </div>
</div>

<style>
    .pos-page {
        text-align: right;
    }

    /* ── Filter chips ─────────────────────────────── */
    .pos-filter-wrap {
        display: flex;
        flex-wrap: wrap;
        gap: 0.35rem;
        justify-content: flex-end;
    }

    .pos-filter-chip {
        display: inline-block;
        font-size: 0.76rem;
        font-weight: 500;
        padding: 0.22rem 0.65rem;
        border-radius: 20px;
        border: 1px solid var(--primary-blue);
        color: var(--primary-blue);
        background: transparent;
        text-decoration: none;
        white-space: nowrap;
        transition: background 0.15s, color 0.15s;
    }

    .pos-filter-chip:hover,
    .pos-filter-chip.active {
        background: var(--primary-blue);
        color: #fff;
    }

    /* ── Location grid ────────────────────────────── */
    /* CSS Grid avoids the percentage-width rounding issues of Bootstrap cols.
       outline instead of border prevents 2px double-lines where cells touch. */
    .pos-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* mobile: 2 columns */
        gap: 5px 3px;                          /* row-gap col-gap */
        max-width: 960px;
        margin-inline: auto;
    }

    @media (min-width: 576px) {
        .pos-grid { grid-template-columns: repeat(3, 1fr); }
    }

    @media (min-width: 992px) {
        .pos-grid { grid-template-columns: repeat(5, 1fr); }
    }

    .pos-card {
        outline: 1px solid var(--tertiary-bg);
        height: 100%;
        min-width: 0; /* prevent overflow inside grid cell */
    }

    .pos-card-icon {
        font-size: 1.3rem;
        color: var(--primary-blue);
        flex-shrink: 0;
    }

    .pos-card-name {
        font-weight: 600;
        font-size: 0.95rem;
        color: var(--primary-text);
        line-height: 1.3;
        overflow-wrap: break-word;
        word-break: break-word;
    }

    .pos-card-address {
        font-size: 0.82rem;
        color: var(--secondary-text);
        padding-inline-start: 0.25rem;
        overflow-wrap: break-word;
        word-break: break-word;
    }

    .pos-card-badge {
        display: inline-block;
        font-size: 0.72rem;
        font-weight: 500;
        color: var(--primary-blue);
        background-color: var(--hover-blue);
        border-radius: 20px;
        padding: 0.2rem 0.65rem;
        align-self: flex-end;
        white-space: nowrap;
    }

    @media (max-width: 575px) {
        .pos-filter-chip  { font-size: 0.71rem; padding: 0.18rem 0.5rem; }
        .pos-card-name    { font-size: 0.76rem; }
        .pos-card-address { font-size: 0.65rem; }
        .pos-card-badge   { font-size: 0.62rem; padding: 0.15rem 0.45rem; }
        .pos-card-icon    { font-size: 1rem; }
    }
</style>
@endsection
