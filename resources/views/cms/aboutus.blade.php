@extends('cms.layout')

@section('title', 'About Us')

@section('content')
    <div class="container mt-5">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Update About Us</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('aboutus.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="aboutUsText" class="font-weight-bold">About Us Content</label>
                        <textarea id="aboutUsText" name="about_us" class="form-control" rows="10" placeholder="Write about us here...">{{ $aboutUs->textarea ?? '' }}</textarea>
                    </div>
                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<style>
    .container {
        max-width: 800px;
        margin: auto;
    }
    .card {
        border-radius: 10px;
    }
    .form-control {
        border-radius: 5px;
        resize: none;
    }
    .btn-success {
        padding: 10px 20px;
        font-size: 16px;
    }
</style>