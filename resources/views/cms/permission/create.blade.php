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

<div class="container mt-5">
    {{-- User Name --}}
    <h2 class="mb-4">{{ $user->name }}</h2>

    {{-- Permissions Form --}}
    <form method="POST" action="{{ route('permissions.update', ['permission' => 0]) }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive rounded-1">
                    <table class="table align-middle mb-0 table-bordered shadow-sm">
                        <thead>
                            <tr>
                                <th>Page</th>
                                <th>
                                    <label class="form-check-label" for="checkAllView">View</label>
                                    <label class="ios-checkbox purple ms-1">
                                        <input type="checkbox" id="checkAllView" class="form-check-input">
                                        <div class="checkbox-wrapper">
                                            <div class="checkbox-bg"></div>
                                            <svg fill="none" viewBox="0 0 24 24" class="checkbox-icon">
                                                <path stroke-linejoin="round" stroke-linecap="round" stroke-width="3" stroke="currentColor" d="M4 12L10 18L20 6" class="check-path"></path>
                                            </svg>
                                        </div>
                                    </label>
                                </th>
                                <th>
                                    <label class="form-check-label" for="checkAllAdd">Add</label>
                                    <label class="ios-checkbox teal ms-1">
                                        <input type="checkbox" id="checkAllAdd" class="form-check-input">
                                        <div class="checkbox-wrapper">
                                            <div class="checkbox-bg"></div>
                                            <svg fill="none" viewBox="0 0 24 24" class="checkbox-icon">
                                                <path stroke-linejoin="round" stroke-linecap="round" stroke-width="3" stroke="currentColor" d="M4 12L10 18L20 6" class="check-path"></path>
                                            </svg>
                                        </div>
                                    </label>
                                </th>
                                <th>
                                    <label class="form-check-label" for="checkAllEdit">Edit</label>
                                    <label class="ios-checkbox yellow ms-1">
                                        <input type="checkbox" id="checkAllEdit" class="form-check-input">
                                        <div class="checkbox-wrapper">
                                            <div class="checkbox-bg"></div>
                                            <svg fill="none" viewBox="0 0 24 24" class="checkbox-icon">
                                                <path stroke-linejoin="round" stroke-linecap="round" stroke-width="3" stroke="currentColor" d="M4 12L10 18L20 6" class="check-path"></path>
                                            </svg>
                                        </div>
                                    </label>
                                </th>
                                <th>
                                    <label class="form-check-label" for="checkAllDelete">Delete</label>
                                    <label class="ios-checkbox red ms-1">
                                        <input type="checkbox" id="checkAllDelete" class="form-check-input">
                                        <div class="checkbox-wrapper">
                                            <div class="checkbox-bg"></div>
                                            <svg fill="none" viewBox="0 0 24 24" class="checkbox-icon">
                                                <path stroke-linejoin="round" stroke-linecap="round" stroke-width="3" stroke="currentColor" d="M4 12L10 18L20 6" class="check-path"></path>
                                            </svg>
                                        </div>
                                    </label>
                                </th>
                                <th>
                                    <label class="form-check-label" for="checkAllExcel">Excel</label>
                                    <label class="ios-checkbox green ms-1">
                                        <input type="checkbox" id="checkAllExcel" class="form-check-input">
                                        <div class="checkbox-wrapper">
                                            <div class="checkbox-bg"></div>
                                            <svg fill="none" viewBox="0 0 24 24" class="checkbox-icon">
                                                <path stroke-linejoin="round" stroke-linecap="round" stroke-width="3" stroke="currentColor" d="M4 12L10 18L20 6" class="check-path"></path>
                                            </svg>
                                        </div>
                                    </label>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pages as $page)
                            @php
                            $permission = Permission::where('user_id', $user->id)
                            ->where('pages_id', $page->id)
                            ->first();
                            @endphp
                            <tr class="bg-hover-light-grey">
                                <td>{{ $page->name }}</td>
                                <td>
                                    <label class="ios-checkbox purple">
                                        <input type="checkbox" name="permissions[{{ $page->id }}][view]" value="1"
                                            {{ $permission && $permission->view ? 'checked' : '' }}>
                                        <div class="checkbox-wrapper">
                                            <div class="checkbox-bg"></div>
                                            <svg fill="none" viewBox="0 0 24 24" class="checkbox-icon">
                                                <path stroke-linejoin="round" stroke-linecap="round" stroke-width="3" stroke="currentColor" d="M4 12L10 18L20 6" class="check-path"></path>
                                            </svg>
                                        </div>
                                    </label>
                                </td>

                                <td>
                                    <label class="ios-checkbox teal">
                                        <input type="checkbox" name="permissions[{{ $page->id }}][add]" value="1"
                                            {{ $permission && $permission->add ? 'checked' : '' }}>
                                        <div class="checkbox-wrapper">
                                            <div class="checkbox-bg"></div>
                                            <svg fill="none" viewBox="0 0 24 24" class="checkbox-icon">
                                                <path stroke-linejoin="round" stroke-linecap="round" stroke-width="3" stroke="currentColor" d="M4 12L10 18L20 6" class="check-path"></path>
                                            </svg>
                                        </div>
                                    </label>
                                </td>

                                <td>
                                    <label class="ios-checkbox yellow">
                                        <input type="checkbox" name="permissions[{{ $page->id }}][edit]" value="1"
                                            {{ $permission && $permission->edit ? 'checked' : '' }}>
                                        <div class="checkbox-wrapper">
                                            <div class="checkbox-bg"></div>
                                            <svg fill="none" viewBox="0 0 24 24" class="checkbox-icon">
                                                <path stroke-linejoin="round" stroke-linecap="round" stroke-width="3" stroke="currentColor" d="M4 12L10 18L20 6" class="check-path"></path>
                                            </svg>
                                        </div>
                                    </label>
                                </td>

                                <td>
                                    <label class="ios-checkbox red">
                                        <input type="checkbox" name="permissions[{{ $page->id }}][delete]" value="1"
                                            {{ $permission && $permission->delete ? 'checked' : '' }}>
                                        <div class="checkbox-wrapper">
                                            <div class="checkbox-bg"></div>
                                            <svg fill="none" viewBox="0 0 24 24" class="checkbox-icon">
                                                <path stroke-linejoin="round" stroke-linecap="round" stroke-width="3" stroke="currentColor" d="M4 12L10 18L20 6" class="check-path"></path>
                                            </svg>
                                        </div>
                                    </label>
                                </td>

                                <td>
                                    <label class="ios-checkbox green">
                                        <input type="checkbox" name="permissions[{{ $page->id }}][excel]" value="1"
                                            {{ $permission && $permission->excel ? 'checked' : '' }}>
                                        <div class="checkbox-wrapper">
                                            <div class="checkbox-bg"></div>
                                            <svg fill="none" viewBox="0 0 24 24" class="checkbox-icon">
                                                <path stroke-linejoin="round" stroke-linecap="round" stroke-width="3" stroke="currentColor" d="M4 12L10 18L20 6" class="check-path"></path>
                                            </svg>
                                        </div>
                                    </label>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-end w-100">
            <button type="submit" class="btn btn-teal fw-medium w-15">Save Changes</button>
        </div>
    </form>
</div>

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