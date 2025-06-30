@php
$types = ['EA' => 'Each', 'CA' => 'Case', 'PL' => 'Pallet'];
$fields = [
['label' => 'Unit Price', 'name' => 'unit_price', 'type' => 'number', 'step' => '0.01', 'required' => true],
['label' => 'Old Price', 'name' => 'old_price', 'type' => 'number', 'step' => '0.01'],
['label' => 'Shelf Price', 'name' => 'shelf_price', 'type' => 'number', 'step' => '0.01' , 'readonly' => true],
['label' => 'Min Quantity', 'name' => 'min_quantity_to_order', 'type' => 'number'],
['label' => 'Max Quantity', 'name' => 'max_quantity_to_order', 'type' => 'number'],
['label' => 'Trade Loader', 'name' => 'trade_loader', 'type' => 'number'],
['label' => 'Trade Loader Qty', 'name' => 'trade_loader_quantity', 'type' => 'number'],
];
@endphp

<ul class="nav nav-tabs mb-3" id="{{ $prefix }}PackagingTabs" role="tablist" style="width: fit-content;">
    @foreach ($types as $key => $label)
    <li class="nav-item" role="presentation">
        <button class="nav-link @if($loop->first) active @endif"
            id="{{ $prefix }}_tab_{{ $key }}"
            data-bs-toggle="tab"
            data-bs-target="#{{ $prefix }}_panel_{{ $key }}"
            type="button" role="tab">
            {{ $label }}
        </button>
    </li>
    @endforeach
</ul>

<div class="tab-content" id="{{ $prefix }}TabContent">
    @foreach ($types as $key => $label)
    <div class="tab-pane fade @if($loop->first) show active @endif"
        id="{{ $prefix }}_panel_{{ $key }}"
        role="tabpanel">
        <h6 class="mt-3 mb-4">{{ $label }} Pricing</h6>

        {{-- Inject hidden UOM field --}}
        <input type="hidden" name="{{ $prefix }}_{{ strtolower($key) }}_UOM" value="{{ $key }}">

        @foreach ($fields as $field)
        <div class="input-container mb-5 mt-3" style="width: 30%;">
            <input
                type="{{ $field['type'] }}"
                name="{{ $prefix }}_{{ strtolower($key) }}_{{ $field['name'] }}"
                id="{{ $prefix }}_{{ strtolower($key) }}_{{ $field['name'] }}"
                step="{{ $field['step'] ?? 'any' }}"
                value="{{ old("{$prefix}_" . strtolower($key) . "_{$field['name']}", $data->{$prefix . '_' . strtolower($key) . '_' . $field['name']} ?? '') }}"
                {{ $field['required'] ?? false ? 'required' : '' }}
                {{ $field['readonly'] ?? false ? 'readonly' : '' }}
                style="width: 100%;"
                placeholder="">
            <label for="{{ $prefix }}_{{ strtolower($key) }}_{{ $field['name'] }}" class="label">{{ $field['label'] }}</label>
            <div class="underline"></div>
        </div>
        @endforeach

    </div>
    @endforeach
</div>