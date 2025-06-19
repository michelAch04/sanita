@extends('sanita.layout')

@section('title', __('Products'))

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">{{ __('All Products') }}</h1>

    @if($products->isEmpty())
    <p class="text-center">{{ __('No products found.') }}</p>
    @else
    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                {{-- Optional image --}}
                @if(!empty($product->extension))
                <img src="{{ asset('storage/' . $product->image_path) }}" class="card-img-top" alt="{{ $product->name }}">
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $product->name_en }}</h5>
                    <p class="card-text mb-2">{{ Str::limit($product->small_description_en, 100) }}</p>
                    <p class="card-text fw-bold">${{ number_format($product->shelf_price, 2) }}</p>
                    {{-- Optional: Add "Add to Cart" button or link --}}
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection