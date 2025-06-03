@extends('cms.layout')

@section('title', 'Carts')
use App\Models\Permission;
$permissions = Permission::with('page')->join('pages', 'permissions.pages_id', '=', 'pages.id')
->where('permissions.user_id', auth()->user()->id)
->where('pages.name', 'Carts')
->first();
$canAdd = $permissions && $permissions->add;
$canEdit = $permissions && $permissions->edit;
$canDelete = $permissions && $permissions->delete;
@endphp

@section('content')
<div class="container mt-5">
    <h2>Manage Carts</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Cart ID</th>
                <th>Customer Name</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($carts as $cart)
            <tr>
                <td>{{ $cart->id }}</td>
                <td>{{ $cart->customer->name }}</td>
                <td>{{ $cart->created_at }}</td>
                <td>{{ $cart->updated_at }}</td>
                <td>
                    @if($canEdit)
                    <a href="{{ route('carts.edit', $cart->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    @endif
                    @if($canDelete)
                    <form action="{{ route('carts.destroy', $cart->id) }}" method="POST" class="d-inline">
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
        </tbody>
    </table>
</div>
@endsection