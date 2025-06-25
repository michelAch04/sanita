<div class="row">
    <div class="col-md-3 mb-3">
        <label class="form-label">Unit Price</label>
        <input type="number" step="0.01" class="form-control" name="{{ $prefix }}_unit_price" required
            value="{{ old($prefix.'_unit_price', $data->unit_price ?? '') }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Old Price</label>
        <input type="number" step="0.01" class="form-control" name="{{ $prefix }}_old_price"
            value="{{ old($prefix.'_old_price', $data->old_price ?? '') }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Min Quantity</label>
        <input type="number" class="form-control" name="{{ $prefix }}_min_quantity_to_order"
            value="{{ old($prefix.'_min_quantity_to_order', $data->min_quantity_to_order ?? '') }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Max Quantity</label>
        <input type="number" class="form-control" name="{{ $prefix }}_max_quantity_to_order"
            value="{{ old($prefix.'_max_quantity_to_order', $data->max_quantity_to_order ?? '') }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Trade Loader</label>
        <input type="number" class="form-control" name="{{ $prefix }}_trade_loader"
            value="{{ old($prefix.'_trade_loader', $data->trade_loader ?? '') }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Trade Loader Qty</label>
        <input type="number" class="form-control" name="{{ $prefix }}_trade_loader_quantity"
            value="{{ old($prefix.'_trade_loader_quantity', $data->trade_loader_quantity ?? '') }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">UOM</label>
        <input type="text" class="form-control" name="{{ $prefix }}_UOM"
            value="{{ old($prefix.'_UOM', $data->UOM ?? '') }}">
    </div>

    <div class="col-md-3 d-flex align-items-center">
        <div class="form-check me-2">
            <input class="form-check-input" type="checkbox" name="{{ $prefix }}_hidden" value="1"
                {{ old($prefix.'_hidden', $data->hidden ?? false) ? 'checked' : '' }}>
            <label class="form-check-label">Hidden</label>
        </div>
        <div class="form-check me-2">
            <input class="form-check-input" type="checkbox" name="{{ $prefix }}_automatic_hide" value="1"
                {{ old($prefix.'_automatic_hide', $data->automatic_hide ?? false) ? 'checked' : '' }}>
            <label class="form-check-label">Auto Hide</label>
        </div>
    </div>
</div>