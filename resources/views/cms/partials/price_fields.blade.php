<div class="row">
    <div class="col-md-3 mb-3">
        <label class="form-label">Unit Price</label>
        <input type="number" step="0.01" class="form-control" name="{{ $prefix }}_unit_price" required>
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Old Price</label>
        <input type="number" step="0.01" class="form-control" name="{{ $prefix }}_old_price">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Min Quantity</label>
        <input type="number" class="form-control" name="{{ $prefix }}_min_quantity_to_order">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Max Quantity</label>
        <input type="number" class="form-control" name="{{ $prefix }}_max_quantity_to_order">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Trade Loader</label>
        <input type="number" class="form-control" name="{{ $prefix }}_trade_loader">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Trade Loader Qty</label>
        <input type="number" class="form-control" name="{{ $prefix }}_trade_loader_quantity">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">UOM</label>
        <input type="text" class="form-control" name="{{ $prefix }}_UOM">
    </div>

    <div class="col-md-3 d-flex align-items-center">
        <div class="form-check me-2">
            <input class="form-check-input" type="checkbox" name="{{ $prefix }}_hidden" value="1">
            <label class="form-check-label">Hidden</label>
        </div>
        <div class="form-check me-2">
            <input class="form-check-input" type="checkbox" name="{{ $prefix }}_automatic_hide" value="1">
            <label class="form-check-label">Auto Hide</label>
        </div>
    </div>
</div>