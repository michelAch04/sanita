@extends('cms.layout')

@section('title', 'Create Tax')

@section('content')
<div class="container mt-3">

    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h2 class="mb-3">Create Tax</h2>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('tax.store') }}" method="POST">
                @csrf

                {{-- Tax Name --}}
                <div class="input-container mb-5 mt-3" style="width: 30%;">
                    <input type="text" id="name" name="name" required style="width: 100%;" placeholder="">
                    <label for="name" class="label">Tax Name</label>
                    <div class="underline"></div>
                </div>

                {{-- Tax Rate --}}
                <div class="input-container mb-5 mt-3" style="width: 30%;">
                    <input type="number" id="rate" name="rate" step="0.01" 
                    placeholder="" required style="width: 100%;">
                    <label for="rate" class="label">Rate (%)</label>
                    <div class="underline"></div>
                </div>

                {{-- Visibility Toggle --}}
                <div class="checkbox-wrapper-8 mb-5">
                    <label for="active" class="visible-label">Visible</label>
                    <input type="checkbox" id="active" name="active" class="tgl" value="1" checked>
                    <label for="active" class="tgl-btn" data-tg-on="Yes" data-tg-off="No"></label>
                </div>

                {{-- Submit & Cancel --}}
                <div class="d-flex justify-content-end">
                    <a href="{{ route('tax.index') }}" class="btn bubbles bubbles-grey me-2">
                        <span class="text">Cancel</span>
                    </a>
                    <button type="submit" class="btn bubbles">
                        <span class="text">Save</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
