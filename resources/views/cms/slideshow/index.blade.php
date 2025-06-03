@extends('cms.layout')

@section('title', 'Slideshow')
@php
use App\Models\Permission;
$permissions = Permission::with('page')->join('pages', 'permissions.pages_id', '=', 'pages.id')
->where('permissions.user_id', auth()->user()->id)
->where('pages.name', 'Slideshow')
->first();
$canAdd = $permissions && $permissions->add;
$canEdit = $permissions && $permissions->edit;
$canDelete = $permissions && $permissions->delete;
@endphp
@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Slideshow</h4>
            @if($canAdd)
            <a href="{{ route('slideshow.create') }}" class="btn btn-primary">+ Create Slide</a>
            @endif
        </div>

        <div class="card-body">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-light">
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
                            <td>
                                <img src="{{ asset('storage/slideshow/' . $slideshow->id . '.' . $slideshow->extension) }}" alt="{{ $slideshow->name }}" class="img-thumbnail" style="width: 80px; height: auto;">
                            </td>
                            <td>{{ $slideshow->name }}</td>
                            <td>{{ $slideshow->hidden ? 'Yes' : 'No' }}</td>
                            <td>{{ $slideshow->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $slideshow->updated_at->format('Y-m-d H:i') }}</td>
                            <td>
                                @if($canEdit)
                                <a href="{{ route('slideshow.edit', $slideshow->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                @endif
                                @if($canDelete)
                                <form action="{{ route('slideshow.destroy', $slideshow->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                                @endif
                                @if(!$canEdit && !$canDelete)
                                <span class="text-muted">No actions available</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach

                        @if ($slideshows->isEmpty())
                        <tr>
                            <td colspan="7" class="text-muted">No slideshow items found.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection