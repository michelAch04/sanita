@php
$fields = [
    ['label' => 'Unit Price', 'name' => 'unit_price', 'type' => 'number', 'step' => '0.01', 'required' => true],
    ['label' => 'Old Price', 'name' => 'old_price', 'type' => 'number', 'step' => '0.01'],
    ['label' => 'Min Quantity', 'name' => 'min_quantity_to_order', 'type' => 'number'],
    ['label' => 'Max Quantity', 'name' => 'max_quantity_to_order', 'type' => 'number'],
    ['label' => 'Trade Loader', 'name' => 'trade_loader', 'type' => 'number'],
    ['label' => 'Trade Loader Qty', 'name' => 'trade_loader_quantity', 'type' => 'number'],
    ['label' => 'UOM', 'name' => 'UOM', 'type' => 'text'],
];
@endphp

@foreach ($fields as $field)
<div class="input-container mb-5 mt-3" style="width: 30%;">
    <input
        type="{{ $field['type'] }}"
        name="{{ $prefix }}_{{ $field['name'] }}"
        id="{{ $prefix }}_{{ $field['name'] }}"
        step="{{ $field['step'] ?? 'any' }}"
        value="{{ old($prefix.'_'.$field['name'], $data->{$field['name']} ?? '') }}"
        {{ $field['required'] ?? false ? 'required' : '' }}
        style="width: 100%;"
        placeholder=""
    >
    <label for="{{ $prefix }}_{{ $field['name'] }}" class="label">{{ $field['label'] }}</label>
    <div class="underline"></div>
</div>
@endforeach

{{-- Checkboxes --}}
<div class="d-flex flex-wrap gap-3 mt-4">
    @php
        $checkboxes = [
            'hidden' => 'Hidden',
            'automatic_hide' => 'Auto Hide',
            'EA' => 'EA',
            'CA' => 'CA',
            'PL' => 'PL',
        ];
    @endphp
    @foreach ($checkboxes as $name => $label)
        <div class="d-flex align-items-center gap-1">
            <label class="ios-checkbox teal">
                <input
                    type="checkbox"
                    id="{{ $prefix }}_{{ $name }}"
                    name="{{ $prefix }}_{{ $name }}"
                    value="1"
                    {{ old($prefix.'_'.$name, $data->{$name} ?? false) ? 'checked' : '' }}
                >
                <div class="checkbox-wrapper">
                    <div class="checkbox-bg"></div>
                    <svg fill="none" viewBox="0 0 24 24" class="checkbox-icon">
                        <path stroke-linejoin="round" stroke-linecap="round" stroke-width="3" stroke="currentColor" d="M4 12L10 18L20 6" class="check-path"></path>
                    </svg>
                </div>
            </label>
            <label class="form-check-label" for="{{ $prefix }}_{{ $name }}">{{ $label }}</label>
        </div>
    @endforeach
</div>
