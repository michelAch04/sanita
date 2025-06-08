@extends('cms.layout')

@section('title', 'About Us')

@php
use App\Models\Permission;
$permissions = Permission::with('page')
->join('pages', 'permissions.pages_id', '=', 'pages.id')
->where('permissions.users_id', auth()->user()->id)
->where('pages.name', 'About Us')
->first();
$canEdit = $permissions && $permissions->edit;
@endphp

@section('content')
<div class="container mt-3">
    {{-- Header --}}
    <div class="card-header text-dark d-flex justify-content-between align-items-center m-2 mb-3">
        <h2 class="mb-0">About Us</h2>
        @if($canEdit)
        <button class="btn bubbles fw-medium" data-bs-toggle="collapse" data-bs-target="#editAboutUs">
           <span class="text"> ✏️ Edit Content </span>
        </button>
        @endif
    </div>

    {{-- Content Display --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            {!! $aboutUs->textarea ?? '<p class="text-muted fst-italic">No About Us content available.</p>' !!}
        </div>
    </div>

    {{-- Collapsible Edit Form --}}
    @if($canEdit)
    <div id="editAboutUs" class="collapse">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('aboutus.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <h4 class="text-center mb-3">Edit Content</h4>
                        <textarea id="aboutUsText" name="about_us" class="form-control" rows="10">{{ $aboutUs->textarea ?? '' }}</textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn bubbles bubbles-green">
                            <span class="text">Update Content</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
/* Editor Container */
.note-editor.note-frame {
    border: 0 !important;
    border-radius: 0.5rem !important;
    box-shadow: 0 0.125rem 0.5rem rgba(0,0,0,0.3) !important;
    font-family: 'Segoe UI', 'Roboto', sans-serif !important;
    font-size: 1rem !important;
}

/* Toolbar */
.note-editor .note-toolbar {
    background-color:rgb(234, 234, 234) !important;
    border-bottom: 1px solid #dee2e6 !important;
    border-top-left-radius: 0.5rem !important;
    border-top-right-radius: 0.5rem !important;
    padding: 0.5rem 1rem !important;
}

/* Toolbar Buttons */
.note-editor .note-toolbar > .note-btn {
    background-color: transparent !important;
    padding: 0.35rem 0.75rem !important;
    color: #212529 !important;
    font-size: 0.875rem !important;
    transition: background-color 0.2s ease;
}

.note-editor > .note-btn:hover {
    background-color:rgb(226, 234, 232) !important;
    color: #000 !important;
}

/* Editable Area */
.note-editor .note-editable {
    padding: 1rem !important;
    border-bottom-left-radius: 0.5rem !important;
    border-bottom-right-radius: 0.5rem !important;
    background-color: #ffffff !important;
    color: #212529 !important;
    line-height: 1.6 !important;
}

.note-editor .note-resizebar {
    background-color:rgb(230, 230, 230) !important; /* Teal (Bootstrap 5 "teal" */
    height: 8px;
    cursor: ns-resize;
}

</style>
@endpush


@push('after-scripts')

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