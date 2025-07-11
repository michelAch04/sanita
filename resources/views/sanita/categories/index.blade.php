@extends('sanita.layout')

@section('title', __('Categories'))

@section('content')
<section id="categories" class="py-3 bg-light">
    <div class="px-5 py-2 gx-0 w-100">
        <h2 class="display-5 text-center mb-5 section-title">{{ __('nav.categories') }}</h2>

        @if($categories->isEmpty())
        <p class="text-center">{{ __('No categories found.') }}</p>
        @else
        <div class="d-flex flex-wrap justify-content-center gap-2">
            @foreach($categories as $category)
                @include('sanita.partials.category-card', [
                'category' => $category,
                'type' => 'categories'
                ])
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $categories->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</section>
@include('sanita.partials.contact-us')
@endsection