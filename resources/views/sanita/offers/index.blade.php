@extends('sanita.layout')

@section('title', __('Offers'))

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">{{ __('Special Offers') }}</h1>

    @if($offers->isEmpty())
    <p class="text-center">{{ __('No offers available currently.') }}</p>
    @else
    <div class="row">
        @foreach($offers as $offer)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                {{-- Optional image --}}
                @if(!empty($offer->extensio))
                <img src="{{ asset('storage/' . $offer->id.$offer->extension) }}" class="card-img-top" alt="{{ $offer->name }}">
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $offer->name_en }}</h5>
                    <p class="card-text mb-2">{{ Str::limit($offer->small_description_en, 100) }}</p>
                    <p class="card-text">
                        <del class="text-muted">${{ number_format($offer->old_price, 2) }}</del>
                        <span class="fw-bold ms-2">${{ number_format($offer->shelf_price, 2) }}</span>
                    </p>
                    {{-- Optional: Add "Add to Cart" button or link --}}
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection