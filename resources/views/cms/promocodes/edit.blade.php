@extends('cms.layout')

@section('title', 'Edit Promo Code')

@section('content')
<div class="ps-5 mt-3">

    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h2 class="mb-3">Edit Promo Code</h2>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('promocodes.update', $promocode->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Code --}}
                <div class="input-container mb-5 mt-3" style="width: 30%;">
                    <input type="text" id="code" name="code" required placeholder="" style="width: 100%;" value="{{ old('code', $promocode->code) }}">
                    <label for="code" class="label">Promo Code</label>
                    <div class="underline"></div>
                </div>

                {{-- Type --}}
                <div class="input-container mb-5" style="width: 30%;">
                    <select id="type" name="type" class="form-select" required>
                        <option value="percentage" {{ old('type', $promocode->type) == 'percentage' ? 'selected' : '' }}>Percentage</option>
                        {{-- Add other types if applicable --}}
                    </select>
                    <label for="type" class="label">Type</label>
                    <div class="underline"></div>
                </div>

                {{-- Value --}}
                <div class="input-container mb-5" style="width: 30%;">
                    <input type="number" id="value" name="value" step="0.01" required placeholder="" style="width: 100%;" value="{{ old('value', $promocode->value) }}">
                    <label for="value" class="label">Value</label>
                    <div class="underline"></div>
                </div>

                {{-- Max Use --}}
                <div class="input-container mb-5" style="width: 30%;">
                    <input type="number" id="max_uses" name="max_uses" placeholder="" style="width: 100%;" value="{{ old('max_uses', $promocode->max_uses) }}">
                    <label for="max_uses" class="label">Max Use</label>
                    <div class="underline"></div>
                </div>

                {{-- Usage Limit --}}
                <div class="input-container mb-5" style="width: 30%;">
                    <input type="number" id="max_uses_per_user" name="max_uses_per_user" placeholder="" style="width: 100%;" value="{{ old('max_uses_per_user', $promocode->max_uses_per_user) }}">
                    <label for="max_uses_per_user" class="label">Max Use Per User</label>
                    <div class="underline"></div>
                </div>

                {{-- Start Date --}}
                <div class="input-container mb-5" style="width: 30%;">
                    <input type="datetime-local" id="start_date" name="start_date" required placeholder="" style="width: 100%;" value="{{ old('start_date', $promocode->start_date ? $promocode->start_date->format('Y-m-d\TH:i') : '') }}">
                    <label for="start_date" class="label">Start Date</label>
                    <div class="underline"></div>
                </div>

                {{-- End Date --}}
                <div class="input-container mb-5" style="width: 30%;">
                    <input type="datetime-local" id="end_date" name="end_date" required placeholder="" style="width: 100%;" value="{{ old('end_date', $promocode->end_date ? $promocode->end_date->format('Y-m-d\TH:i') : '') }}">
                    <label for="end_date" class="label">End Date</label>
                    <div class="underline"></div>
                </div>

                {{-- Submit & Cancel --}}
                <div class="d-flex justify-content-end">
                    <a href="{{ route('promocodes.index') }}" class="btn bubbles bubbles-grey me-2">
                        <span class="text">Cancel</span>
                    </a>
                    <button type="submit" class="btn bubbles">
                        <span class="text">Update</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
