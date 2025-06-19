@extends('sanita.layout')

@section('title', __('Categories'))

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">{{ __('All Categories') }}</h1>

    @if($categories->isEmpty())
    <p class="text-center">{{ __('No categories found.') }}</p>
    @else
    <div class="row">
        @foreach($categories as $category)
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title">{{ $category->name_en }}</h5>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection