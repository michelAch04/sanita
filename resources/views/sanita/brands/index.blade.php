@extends('sanita.layout')

@section('title', __('Brands'))

@section('content')
<section id="Brands" class="py-3 bg-light products-list">
    <div class="px-5 py-2 gx-0 w-100">
        <h2 class="display-5 text-center mb-5 section-title">{{ __('nav.Brands') }}</h2>

        @if($brands->isEmpty())
        <p class="text-center">{{ __('No brands found.') }}</p>
        @else
        <div class="d-flex flex-wrap justify-content-center gap-2 list-container">
            @foreach( $brands as $brand)
            @include('sanita.partials.brand-card', [
            'category' => $brand,
            'type' => 'brands'
            ])
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $brands->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</section>
@include('sanita.partials.contact-us')
@endsection