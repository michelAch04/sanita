@extends('sanita.layout')

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4 mt-4">About Us</h2>
        <p class="text-center">
            {!! $aboutUs->textarea !!}
        </p>
    </div>
</section>
@endsection