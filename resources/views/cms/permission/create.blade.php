@extends('cms.layout')



@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="container mt-4">
    <div class="mb-3">
        <label for="userSelect" class="form-label">Select User</label>
        <select id="userSelect" class="form-select" style="width: 300px;">
            <option value="">-- Select User --</option>
            @foreach($users as $u)
            <option value="{{ route('permissions.create', ['user_id' => $u->id]) }}"
                {{ (request('user_id') == $u->id) ? 'selected' : '' }}>
                {{ $u->email }}
            </option>
            @endforeach
        </select>
    </div>
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
    document.getElementById('userSelect').addEventListener('change', function() {
        if (this.value) {
            window.location.href = this.value;
        }
    });

    // Check All functionality
    document.getElementById('checkAllView').addEventListener('change', function() {
        document.querySelectorAll('input[type="checkbox"][name*="[view]"]').forEach(cb => cb.checked = this.checked);
    });
    document.getElementById('checkAllAdd').addEventListener('change', function() {
        document.querySelectorAll('input[type="checkbox"][name*="[add]"]').forEach(cb => cb.checked = this.checked);
    });
    document.getElementById('checkAllEdit').addEventListener('change', function() {
        document.querySelectorAll('input[type="checkbox"][name*="[edit]"]').forEach(cb => cb.checked = this.checked);
    });
    document.getElementById('checkAllDelete').addEventListener('change', function() {
        document.querySelectorAll('input[type="checkbox"][name*="[delete]"]').forEach(cb => cb.checked = this.checked);
    });
    document.getElementById('checkAllExcel').addEventListener('change', function() {
        document.querySelectorAll('input[type="checkbox"][name*="[excel]"]').forEach(cb => cb.checked = this.checked);
    });
</script>
@endsection