@extends('cms.layout')

@section('content')
<div class="container mt-5">
    <h2>Assign Permissions</h2>
    <div class="mb-3">
        <label for="userSelect" class="form-label">Select User</label>
        <select id="userSelect" class="form-select">
            <option value="">-- Select User --</option>
            @foreach($users as $user)
            <option value="{{ route('permissions.create', ['user_id' => $user->id]) }}">{{ $user->email }}</option>
            @endforeach
        </select>
    </div>
</div>

<script>
    document.getElementById('userSelect').addEventListener('change', function() {
        if (this.value) {
            window.location.href = this.value;
        }
    });
</script>
@endsection