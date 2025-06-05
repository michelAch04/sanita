@extends('cms.layout')

@section('title', 'Edit Permissions')

@php
use App\Models\Permission;
@endphp
@push('styles')
<style>
    nav {
        display: none !important;
    }

    main {
        margin-left: 0 !important;
        width: 100% !important;
    }
</style>
@endpush

@section('content')

@if ($errors->any())
@foreach ($errors->all() as $error)
<script>
    window.addEventListener('DOMContentLoaded', function() {
        showToast('danger', '{!! json_encode($error) !!}');
    });
</script>
@endforeach
@endif

@if (session('success'))
<script>
    window.addEventListener('DOMContentLoaded', function() {
        showToast('success', '{!! json_encode(session('
            success ')) !!}');
        setTimeout(() => {
            window.close();
        }, 2500);
    });
</script>
@endif

{{-- Back Button --}}
<div class="mb-3">
    <button onclick="window.close()" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back
    </button>
</div>

@if(isset($user))
<h4 class="mt-4">{{ $user->name }}</h4>
<form method="POST" action="{{ route('permissions.update', ['permission' => 0]) }}">
    @csrf
    @method('PUT')
    <input type="hidden" name="user_id" value="{{ $user->id }}">
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Page</th>
                <th>
                    View<br>
                    <input type="checkbox" id="checkAllView">
                </th>
                <th>
                    Add<br>
                    <input type="checkbox" id="checkAllAdd">
                </th>
                <th>
                    Edit<br>
                    <input type="checkbox" id="checkAllEdit">
                </th>
                <th>
                    Delete<br>
                    <input type="checkbox" id="checkAllDelete">
                </th>
                <th>
                    Excel<br>
                    <input type="checkbox" id="checkAllExcel">
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($pages as $page)
            @php
            $permission = \App\Models\Permission::where('user_id', $user->id)
            ->where('pages_id', $page->id)
            ->first();
            @endphp
            <tr>
                <td>{{ $page->name }}</td>
                <td>
                    <input type="checkbox" name="permissions[{{ $page->id }}][view]" value="1"
                        {{ $permission && $permission->view ? 'checked' : '' }}>
                </td>
                <td>
                    <input type="checkbox" name="permissions[{{ $page->id }}][add]" value="1"
                        {{ $permission && $permission->add ? 'checked' : '' }}>
                </td>
                <td>
                    <input type="checkbox" name="permissions[{{ $page->id }}][edit]" value="1"
                        {{ $permission && $permission->edit ? 'checked' : '' }}>
                </td>
                <td>
                    <input type="checkbox" name="permissions[{{ $page->id }}][delete]" value="1"
                        {{ $permission && $permission->delete ? 'checked' : '' }}>
                </td>
                <td>
                    <input type="checkbox" name="permissions[{{ $page->id }}][excel]" value="1"
                        {{ $permission && $permission->excel ? 'checked' : '' }}>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <button type="submit" class="btn btn-primary">Save</button>
</form>
@endif


<script>
    // Check All functionality
    document.getElementById('checkAllView')?.addEventListener('change', function() {
        document.querySelectorAll('input[name*="[view]"]').forEach(cb => cb.checked = this.checked);
    });
    document.getElementById('checkAllAdd')?.addEventListener('change', function() {
        document.querySelectorAll('input[name*="[add]"]').forEach(cb => cb.checked = this.checked);
    });
    document.getElementById('checkAllEdit')?.addEventListener('change', function() {
        document.querySelectorAll('input[name*="[edit]"]').forEach(cb => cb.checked = this.checked);
    });
    document.getElementById('checkAllDelete')?.addEventListener('change', function() {
        document.querySelectorAll('input[name*="[delete]"]').forEach(cb => cb.checked = this.checked);
    });
    document.getElementById('checkAllExcel')?.addEventListener('change', function() {
        document.querySelectorAll('input[name*="[excel]"]').forEach(cb => cb.checked = this.checked);
    });
</script>
@endsection