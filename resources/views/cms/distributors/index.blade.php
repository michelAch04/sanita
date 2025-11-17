@extends('cms.layout')

@section('title', 'Distributors')

@php
use App\Models\Permission;
$permissions = Permission::with('page')
->join('pages', 'permissions.pages_id', '=', 'pages.id')
->where('permissions.users_id', auth()->user()->id)
->where('pages.name', 'Distributors')
->first();

$canAdd = $permissions && $permissions->add;
$canEdit = $permissions && $permissions->edit;
$canDelete = $permissions && $permissions->delete;
@endphp

@section('content')
{{-- Search --}}
<div class="d-flex justify-content-center w-100 mb-3">
  <form class="search-form d-flex align-items-center w-50" data-search-target="#distributor-table-body" action="{{ route('distributor.index') }}">
    <input type="text" name="query" class="form-control me-2 search-input rounded-pill shadow-soft" placeholder="Search..." autocomplete="off">
  </form>
</div>

<div class="ps-4 mt-5 ms-0 me-0" style="width: 95vw !important;">
  <div class="card-header text-dark d-flex justify-content-between align-items-center m-2 mb-3">
    <h2 class="mb-0">Distributors</h2>
    @if($canAdd)
    <a href="{{ route('distributor.create') }}" class="btn bubbles fw-medium">
      <span class="text">+ Create Distributor</span>
    </a>
    @endif
  </div>

  <div class="card shadow-sm border-0">
    <div class="card-body p-0">
      <div class="table-responsive rounded-1" style="overflow-x: auto !important;">
        <table class="table mb-0 mr-0 w-100">
          <thead class="bg-grey text-dark opacity-75">
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Mobile</th>
              <th>Location</th>
              <th class="text-end">Options</th>
            </tr>
          </thead>
          <tbody id="distributor-table-body">
            @section('distributors_list')
            @forelse($distributors as $distributor)
            <tr class="bg-hover-light-grey">
              <td>{{ $distributor->name }}</td>
              <td>{{ $distributor->email }}</td>
              <td>{{ $distributor->mobile }}</td>
              <td>{{ $distributor->location }}</td>
              <td class="text-end">
                @if($canEdit || $canDelete)
                <button type="button"
                  class="btn btn-sm text-secondary rounded-circle border-0 bg-hover-teal open-actions-modal"
                  data-bs-toggle="modal"
                  data-bs-target="#actionsModal"
                  data-id="{{ $distributor->id }}"
                  data-name="{{ $distributor->name }}"
                  data-edit="{{ $canEdit ? route('distributor.edit', $distributor->id) : '' }}"
                  data-address="{{ $canEdit ? route('distributor.addAddress', $distributor->id) : '' }}"
                  data-stocks="{{ $canEdit ? route('distributor.stocks', $distributor->id) : '' }}"
                  data-delete="{{ $canDelete ? route('distributor.destroy', $distributor->id) : '' }}">
                  <i class="bi bi-three-dots-vertical"></i>
                </button>
                @else
                <span class="text-muted">—</span>
                @endif
              </td>
            </tr>
            @empty
            <tr class="bg-hover-light-grey">
              <td colspan="5" class="text-center text-muted">No distributors found.</td>
            </tr>
            @endforelse
            @endsection
            @yield('distributors_list')
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Actions Modal -->
<div class="modal fade" id="actionsModal" tabindex="-1" aria-labelledby="actionsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="actionsModalLabel">Distributor Actions</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @if($canEdit || $canDelete)
        <div class="d-grid gap-2">
          @if($canEdit)
          <a href="#" id="editLink" class="btn btn-outline-primary">
            <i class="bi bi-pencil-square me-1"></i> Edit
          </a>
          <a href="#" id="addressLink" class="btn btn-outline-secondary">
            <i class="bi bi-geo-alt me-1"></i> Add City
          </a>
          <a href="#" id="stocksLink" class="btn btn-outline-success">
            <i class="bi bi-box-seam me-1"></i> Add Stock
          </a>
          @endif

          @if($canDelete)
          <button type="button" class="btn btn-outline-danger" id="deleteButton">
            <i class="bi bi-trash3 me-1"></i> Delete
          </button>
          @endif
        </div>
        @else
        <p class="text-center text-muted">No actions available.</p>
        @endif
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const actionsModalEl = document.getElementById('actionsModal');
    const actionsModal = new bootstrap.Modal(actionsModalEl);
    let currentDeleteUrl = null;

    document.querySelectorAll('.open-actions-modal').forEach(button => {
      button.addEventListener('click', function() {
        const id = this.dataset.id;
        const name = this.dataset.name;
        const editUrl = this.dataset.edit;
        const addressUrl = this.dataset.address;
        const stocksUrl = this.dataset.stocks;
        const deleteUrl = this.dataset.delete;

        // Set modal title dynamically
        document.getElementById('actionsModalLabel').textContent = `Actions for: ${name}`;

        // Set or disable links/buttons based on permissions and availability
        const editLink = document.getElementById('editLink');
        const addressLink = document.getElementById('addressLink');
        const stocksLink = document.getElementById('stocksLink');
        const deleteButton = document.getElementById('deleteButton');

        if (editLink) {
          if (editUrl) {
            editLink.href = editUrl;
            editLink.style.display = 'inline-block';
          } else {
            editLink.style.display = 'none';
          }
        }

        if (addressLink) {
          if (addressUrl) {
            addressLink.href = addressUrl;
            addressLink.style.display = 'inline-block';
          } else {
            addressLink.style.display = 'none';
          }
        }

        if (stocksLink) {
          if (stocksUrl) {
            stocksLink.href = stocksUrl;
            stocksLink.style.display = 'inline-block';
          } else {
            stocksLink.style.display = 'none';
          }
        }

        if (deleteButton) {
          if (deleteUrl) {
            deleteButton.style.display = 'inline-block';
            currentDeleteUrl = deleteUrl;
          } else {
            deleteButton.style.display = 'none';
            currentDeleteUrl = null;
          }
        }
      });
    });

    // Delete confirmation button
    const deleteButton = document.getElementById('deleteButton');
    if (deleteButton) {
      deleteButton.addEventListener('click', function() {
        if (!currentDeleteUrl) return;

        if (confirm('Are you sure you want to delete this distributor?')) {
          // Create and submit a form for DELETE request with CSRF token
          const form = document.createElement('form');
          form.method = 'POST';
          form.action = currentDeleteUrl;

          const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
          const csrfInput = document.createElement('input');
          csrfInput.type = 'hidden';
          csrfInput.name = '_token';
          csrfInput.value = csrfToken;
          form.appendChild(csrfInput);

          const methodInput = document.createElement('input');
          methodInput.type = 'hidden';
          methodInput.name = '_method';
          methodInput.value = 'DELETE';
          form.appendChild(methodInput);

          document.body.appendChild(form);
          form.submit();
        }
      });
    }
  });
</script>

@endsection