@extends('sanita.layout')

@section('content')
@php
$isRtl = app()->getLocale() === 'ar';
@endphp
<section class="py-5 bg-white">
    <div class="container mt-5 mb-5">
        <h2 class="text-center mb-4">{{ __('contact.title') }}</h2>
        <form class="mx-auto" style="max-width: 600px;">
            <div class="mb-3">
                <label for="name" class="form-label {{ $isRtl ? 'text-end w-100' : '' }}">{{ __('contact.your_name') }}</label>
                <input type="text" class="form-control" id="name" placeholder="{{ __('contact.your_name') }}" {{ $isRtl ? 'dir=rtl' : '' }}>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label {{ $isRtl ? 'text-end w-100' : '' }}">{{ __('contact.your_email') }}</label>
                <input type="email" class="form-control" id="email" placeholder="{{ __('contact.your_email') }}" {{ $isRtl ? 'dir=rtl' : '' }}>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label {{ $isRtl ? 'text-end w-100' : '' }}">{{ __('contact.phone') }}</label>
                <input type="text" class="form-control" id="phone" placeholder="{{ __('contact.phone') }}" {{ $isRtl ? 'dir=rtl' : '' }}>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label {{ $isRtl ? 'text-end w-100' : '' }}">{{ __('contact.your_message') }}</label>
                <textarea class="form-control" id="message" rows="4" placeholder="{{ __('contact.your_message') }}" {{ $isRtl ? 'dir=rtl' : '' }}></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-dark">{{ __('contact.send_message') }}</button>
            </div>
        </form>
    </div>
</section>
@endsection