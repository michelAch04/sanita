@extends('sanita.layout')

@section('title', __('nav.pos_title') . ' — Sanita')

@section('content')
<div class="container my-4 px-3">
    <h2 class="display-5 text-center mb-4 section-title px-1">{{ __('nav.pos_title') }}</h2>

    @if ($locations->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-geo-alt" style="font-size: 3rem; color: var(--primary-blue);"></i>
            <p class="mt-3 text-secondary">{{ __('nav.pos_no_locations') }}</p>
        </div>
    @else
        <div class="row g-3">
            @foreach ($locations as $loc)
            <div class="col-12 col-sm-6 col-md-4">
                <div class="pos-card h-100 bg-white rounded shadow-sm p-3 d-flex flex-column gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-geo-alt-fill pos-card-icon"></i>
                        <span class="pos-card-name">{{ $loc->name }}</span>
                    </div>
                    <p class="pos-card-address mb-0">{{ $loc->address }}</p>
                    @if ($loc->city)
                        <span class="pos-card-badge">
                            {{ $loc->city->{'name_' . app()->getLocale()} ?? $loc->city->name_en }}
                        </span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    .pos-card {
        border: 1px solid var(--tertiary-bg);
        transition: box-shadow 0.2s ease, transform 0.2s ease;
    }

    .pos-card:hover {
        box-shadow: 0 4px 16px rgba(42, 67, 101, 0.12) !important;
        transform: translateY(-2px);
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
    }

    .pos-card-address {
        font-size: 0.82rem;
        color: var(--secondary-text);
        padding-left: 0.25rem;
    }

    .pos-card-badge {
        display: inline-block;
        font-size: 0.72rem;
        font-weight: 500;
        color: var(--primary-blue);
        background-color: var(--hover-blue);
        border-radius: 20px;
        padding: 0.2rem 0.65rem;
        align-self: flex-start;
    }

    @media (max-width: 612px) {
        .pos-card-name {
            font-size: 0.88rem;
        }

        .pos-card-address {
            font-size: 0.78rem;
        }
    }
</style>
@endsection
