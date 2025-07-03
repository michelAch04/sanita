@extends('sanita.layout')

@section('title', __('Categories'))

@section('content')
<section id="categories" class="py-3 bg-light">
    <div class="p-5 gx-0 w-100">
        <h2 class="display-5 text-center mb-4 section-title">{{ __('nav.categories') }}</h2>

        @if($categories->isEmpty())
        <p class="text-center">{{ __('No categories found.') }}</p>
        @else
        <div class="d-flex flex-wrap justify-content-center gap-2">
            @foreach($categories as $category)
            <div class="category-card" data-url="{{ route('website.category.index', ['locale' => app()->getLocale(), 'category' => $category->id]) }}">
                <div class="category-card-body">
                    @if($category->extension)
                    <img src="{{ asset('storage/categories/' . $category->id . '.' . $category->extension) }}"
                        alt="{{ $category->{'name_'.app()->getLocale()} ?? $category->name_en }}"
                        class="img-fluid mb-4">
                    @endif
                    <h5 class="card-title">
                        <a href="{{ route('website.category.index', ['locale' => app()->getLocale(), 'category' => $category->id]) }}"
                            class="text-decoration-none text-dark">
                            {{ $category->{'name_'.app()->getLocale()} ?? $category->name_en }}
                        </a>
                    </h5>
                    @if(!empty($category->description))
                    <p class="card-text text-muted text-center small">
                        {{ $category->{'description_'.app()->getLocale()} ?? $category->description }}
                    </p>
                    @endif
                </div>
            </div>
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