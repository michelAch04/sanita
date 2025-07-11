@extends('cms.layout')

@section('title', 'Manage Stocks for ' . $distributor->name)

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Manage Stocks for {{ $distributor->name }}</h2>
        <a href="{{ route('distributor.index') }}" class="btn bubbles bubbles-grey">
            <span class="text"><i class="bi bi-arrow-left me-1"></i>Back to Distributors</span>
        </a>
    </div>

      <div class="mb-3 text-end">
        <input type="file" id="stockExcelInput" accept=".xlsx,.xls" style="display:none;">
        <button type="button" class="btn bubbles bubbles-grey" onclick="document.getElementById('stockExcelInput').click();">
            <span class="text"><i class="bi bi-upload"></i> Add Stock (Excel)</span>
        </button>
    </div>

    <ul class="nav nav-tabs mb-4" id="stockTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="manage-tab" data-bs-toggle="tab" data-bs-target="#manage" type="button">Add/Update Stocks</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="list-tab" data-bs-toggle="tab" data-bs-target="#list" type="button">Current Stocks</button>
        </li>
    </ul>

    <div class="tab-content" id="stockTabsContent">
        {{-- Add/Update Tab --}}
        <div class="tab-pane fade show active" id="manage" role="tabpanel">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <form id="stockForm" action="{{ route('distributor.storeStock', $distributor->id) }}" method="POST">
                        @csrf
                        <input type="hidden" id="editMode" value="false">
                        <div class="col-md-5">
                            <label for="products_id" class="form-label">Select Product</label>
                            <select name="products_id" id="products_id" class="form-select styled-select" required>
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name_en ?? $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex justify-content-between align-items-end w-100 mt-4">
                            <div class="input-container col-md-2">
                                <input type="number" id="stock" name="stock" class="styled-input" style="width: 100%;" value="{{ old('stock') }}" placeholder="">
                                <label for="stock" class="label">Stock Count</label>
                                <div class="underline"></div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn bubbles w-100">
                                    <span class="text">Add / Update</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Current Stocks Tab --}}
        <div class="tab-pane fade" id="list" role="tabpanel">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-center w-100 mb-5">
                        <input type="text" id="searchStock" class="form-control w-75 search-input rounded-pill shadow-soft" placeholder="Search product name or SKU...">
                    </div>
                    <div class="table-responsive rounded-1">
                        <table class="table mb-0 w-100" id="stockTable">
                            <thead class="bg-grey text-dark opacity-75">
                                <tr>
                                    <th>Product</th>
                                    <th>Product Name</th>
                                    <th>Stock</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="distributorStock-table-body">
                                @forelse($distributor->stocks as $stock)
                                <tr class="bg-hover-light-grey">
                                    <td>{{ $stock->product->sku }}</td>
                                    <td>{{ $stock->product->name_en }}</td>
                                    <td>{{ $stock->stock }}</td>
                                    <td class="text-end">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-primary me-1"
                                            onclick="editStock({{ $stock->product->id }}, {{ $stock->stock }})">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger"
                                            onclick="confirmDelete('{{ route('distributor.removeStock', [$distributor->id, $stock->product->id]) }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr class="bg-hover-light-grey">
                                    <td colspan="4" class="text-center text-muted">No stock records found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('cms.partials.select2', [
    'id' => '#products_id',
    'placeholder' => 'Select a Product',
])
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script>
    $(document).ready(function() {
        $('#searchStock').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#distributorStock-table-body tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    });

    function editStock(productId, stockValue) {
        // Activate the first tab (input tab)
        document.getElementById('manage-tab').click();

        // Set the form values
        $('#products_id').val(productId).trigger('change');
        $('#stock').val(stockValue);
    }

     document.getElementById('stockExcelInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, { type: 'array' });
            const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
            const rows = XLSX.utils.sheet_to_json(firstSheet, { header: 1 });

            // Assuming the Excel columns are: item_code | stock
            // Skip header row
            const products = rows.slice(1)
                .filter(row => row[0] && row[1])
                .map(row => ({
                    item_code: String(row[0]).trim(),
                    stock: parseInt(row[1])
                }));

            const payload = {
                distributor_id: '{{ $distributor->id }}',
                products: products
            };

            fetch('{{ url("/api/distributor/add-stock") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Basic {{ base64_encode(env('API_AUTH_USERNAME') . ':' . env('API_AUTH_PASSWORD')) }}',
                    'Accept': 'application/json',
                      'X-CSRF-TOKEN': csrfToken 
                },
                body: JSON.stringify(payload)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAjaxToast('success','Stock added successfully!');
                } else {
                    showAjaxToast('warning','Failed to add stock: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                alert('Error: ' + error);
            });
        };
        reader.readAsArrayBuffer(file);
    });
</script>
@endpush

@endsection