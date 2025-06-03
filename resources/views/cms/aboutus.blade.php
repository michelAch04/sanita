@extends('cms.layout')

@section('title', 'About Us')

@section('content')
<div class="container mt-5">
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-light text-black">
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
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- Summernote CSS (Bootstrap 5 compatible version) -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('scripts')
<!-- jQuery (required for Summernote) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#aboutUsText').summernote({
            height: 300,
            placeholder: 'Write about us here...',
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
@endpush