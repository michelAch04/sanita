@extends('sanita.layout')
@section('title', __('Your Addresses'))

@section('content')
<div class="container py-5">
    <h2 class="mb-4">{{ __('Your Addresses') }}</h2>

    <a href="{{ route('addresses.create', app()->getLocale()) }}" class="btn btn-success mb-3">{{ __('Add Address') }}</a>

    @foreach ($addresses as $address)
    <div class="card mb-3">
        <div class="card-body">
            <h5>{{ $address->title ?? __('Untitled') }}</h5>
            <p>{{ $address->street }}, {{ $address->building }}, {{ $address->city->name_en }} - {{ $address->district->name_en }}, {{ $address->governorate->name_en }}</p>
            <p>{{ $address->notes }}</p>

            <a href="{{ route('addresses.edit', [app()->getLocale(), $address]) }}" class="btn btn-primary">{{ __('Edit') }}</a>

            <form action="{{ route('addresses.destroy', [app()->getLocale(), $address]) }}" method="POST" style="display:inline-block">
                @csrf @method('DELETE')
                <button class="btn btn-danger" onclick="return confirm('{{ __('Are you sure?') }}')">{{ __('Delete') }}</button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection