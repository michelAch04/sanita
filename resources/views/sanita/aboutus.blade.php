@extends('sanita.layout')

@section('content')
@php
$isRtl = app()->getLocale() === 'ar';
@endphp
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4 mt-4">{{ __('about.title') }}</h2>
        <p class="text-center" {{ $isRtl ? 'dir=rtl' : '' }}>
            {!! $aboutUs->{'textarea_' . app()->getLocale()} !!}
        </p>
    </div>
</section>
@endsection