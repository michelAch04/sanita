@extends('sanita.layout')

@section('content')

<section class="py-5">
    <h2 class="text-center mb-4 mt-4 section-title">{{ __('about.title') }}</h2>
    <div class="container bg-white rounded-1">
        <p class="p-2 text-start" {{ $isRtl ? 'dir=rtl' : '' }}>
            @if ($aboutUs)
                {{ strip_tags($aboutUs->{'textarea_' . app()->getLocale()}) }}
            @else
                <p>About Us information is not available.</p>
            @endif
        </p>
    </div>
</section>
@endsection