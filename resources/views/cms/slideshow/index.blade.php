@extends('cms.layout')

@section('title', 'Slideshow')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Slideshow</h1>

    <a href="{{ route('slideshow.create') }}" class="btn btn-primary mb-4">Add New Slide</a>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Hidden</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($slideshows as $slideshow)
            <tr>
                <td>{{ $slideshow->id }}</td>
                <td><img src="{{ asset('storage/slideshow/' . $slideshow->id .'.'. $slideshow->extension) }}" alt="{{ $slideshow->name }}" width="100"></td>
                <td>{{ $slideshow->name }}</td>
                <td>{{ $slideshow->hidden }}</td>
                <td>{{ $slideshow->created_at }}</td>
                <td> {{ $slideshow->updated_at }}</td>
                <td>
                    <a href="{{ route('slideshow.edit', $slideshow->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('slideshow.destroy', $slideshow->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection