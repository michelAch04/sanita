@extends('sanita.layout')

@section('title', __('nav.pos_title') . ' — Sanita')

@section('content')
<div class="pos-page" dir="rtl">
    <div class="container py-3 px-2 px-sm-3">

        <h2 class="display-6 text-center mb-3 section-title">{{ __('nav.pos_title') }}</h2>

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
            <div class="row g-2">
                @foreach ($locations as $loc)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="pos-card bg-white rounded p-2 d-flex flex-column gap-1">
                        <div class="d-flex align-items-start gap-1">
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
                </div>
                @endforeach
            </div>

            @if ($locations->hasPages())
            <div class="d-flex justify-content-center list-pagination mt-3">
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

    .pos-card {
        border: 1px solid var(--tertiary-bg);
        height: 100%;
        transition: box-shadow 0.15s ease, transform 0.15s ease;
    }

    .pos-card:hover {
        box-shadow: 0 3px 10px rgba(42, 67, 101, 0.1) !important;
        transform: translateY(-1px);
    }

    .pos-card-icon {
        font-size: 0.85rem;
        color: var(--primary-blue);
        flex-shrink: 0;
    }

    .pos-card-name {
        font-weight: 600;
        font-size: 0.82rem;
        color: var(--primary-text);
        line-height: 1.3;
    }

    .pos-card-address {
        font-size: 0.74rem;
        color: var(--secondary-text);
        line-height: 1.4;
    }

    .pos-card-badge {
        display: inline-block;
        font-size: 0.66rem;
        font-weight: 500;
        color: var(--primary-blue);
        background-color: var(--hover-blue);
        border-radius: 20px;
        padding: 0.12rem 0.45rem;
        align-self: flex-end;
    }

    @media (max-width: 612px) {
        .pos-card-name  { font-size: 0.76rem; }
        .pos-card-address { font-size: 0.68rem; }
        .pos-filter-chip { font-size: 0.71rem; padding: 0.18rem 0.5rem; }
    }
</style>
@endsection
