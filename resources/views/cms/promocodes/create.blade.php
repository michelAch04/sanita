@extends('cms.layout')

@section('title', 'Create Promo Code')

@section('content')
<div class="ps-5 mt-3">

    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h2 class="mb-3">Create Promo Code</h2>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('promocodes.store') }}" method="POST">
                @csrf

                {{-- Code --}}
                <div class="input-container mb-5 mt-3" style="width: 30%;">
                    <input type="text" id="code" name="code" required placeholder="" style="width: 100%;">
                    <label for="code" class="label">Promo Code</label>
                    <div class="underline"></div>
                </div>

                {{-- Type --}}
                <div class="input-container mb-5" style="width: 30%;">
                    <select id="type" name="type" class="form-select" required>
                        <option value="percentage">Percentage</option>
                    </select>
                    <label for="type" class="label">Type</label>
                    <div class="underline"></div>
                </div>

                {{-- Value --}}
                <div class="input-container mb-5" style="width: 30%;">
                    <input type="number" id="value" name="value" step="0.01" required placeholder="" style="width: 100%;">
                    <label for="value" class="label">Value</label>
                    <div class="underline"></div>
                </div>

                {{-- Usage Limit --}}
                <div class="input-container mb-5" style="width: 30%;">
                    <input type="number" id="usage_limit" name="usage_limit" placeholder="" style="width: 100%;">
                    <label for="usage_limit" class="label">Usage Limit (optional)</label>
                    <div class="underline"></div>
                </div>

                {{-- Start Date --}}
                <div class="input-container mb-5" style="width: 30%;">
                    <input type="datetime-local" id="start_date" name="start_date" required placeholder="" style="width: 100%;">
                    <label for="start_date" class="label">Start Date</label>
                    <div class="underline"></div>
                </div>

                {{-- End Date --}}
                <div class="input-container mb-5" style="width: 30%;">
                    <input type="datetime-local" id="end_date" name="end_date" required placeholder="" style="width: 100%;">
                    <label for="end_date" class="label">End Date</label>
                    <div class="underline"></div>
                </div>

                {{-- Active Toggle --}}
                <div class="checkbox-wrapper-8 mb-5">
                    <label for="is_active" class="visible-label">Visible</label>
                    <input type="checkbox" id="is_active" name="is_active" class="tgl" value="1" checked>
                    <label for="is_active" class="tgl-btn" data-tg-on="Yes" data-tg-off="No"></label>
                </div>

                {{-- Submit & Cancel --}}
                <div class="d-flex justify-content-end">
                    <a href="{{ route('promocodes.index') }}" class="btn bubbles bubbles-grey me-2">
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
