@extends('cms.layout')

@section('title', 'Assign City to Distributor')

@section('content')
<div class="container mt-4">
    <h2>Assign City to {{ $distributor->name }}</h2>

    <form method="POST" action="{{ route('distributor.storeAddress', $distributor->id) }}">
        @csrf
        <div class="mb-3">
            <label for="cities_id" class="form-label">Select City</label>
            <select name="cities_id" class="form-select" required>
                <option value="">-- Choose City --</option>
                @foreach($cities as $city)
                <option value="{{ $city->id }}">{{ $city->name_en }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Assign City</button>
        <a href="{{ route('distributor.index') }}" class="btn btn-secondary">Back</a>
    </form>

    <h4 class="mt-4">Assigned Cities</h4>
    <ul>
        @foreach($distributor->addresses as $address)
        <li>{{ $address->city->name_en }}</li>
        @endforeach
    </ul>
</div>
@endsection