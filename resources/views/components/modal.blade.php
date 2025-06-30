@php
if (str_starts_with(request()->path(), 'cms')) {
$isRtl = 0;
}

@endphp
{{-- Global Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header text-white" style="background-color:rgba(204, 0, 0, 0.63);">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    Are you sure you want to delete this item?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="opacity: 0.63;">Cancel</button>
                    <button type="submit" class="btn btn-danger" style="background-color:rgba(204, 0, 0, 0.63);">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Logout Modal --}}
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <div class="modal-body">
                    Are you sure you want to log out?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Logout</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Add to Cart Modal --}}
<div class="modal fade {{ $isRtl ? 'rtl-container' : '' }}" id="addToCartModal" tabindex="-1" aria-labelledby="addToCartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header text-white" style="background: var(--primary-blue);">
                <h5 class="modal-title" id="addToCartModalLabel">Add to Cart</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addToCartForm">
                <div class="modal-body">
                    <div class="mb-2">
                        <span id="modalProductDescriptionDisplay" class="text-muted"></span>
                    </div>
                    <div class="mb-4">
                        <span id="modalProductOldPriceDisplay" class="text-muted text-decoration-line-through me-2" style="display:none;"></span>
                        <span id="modalProductShelfPrice" class="fw-bold" style="color: var(--primary-text);"></span>
                    </div>
                    <div class="mb-3">
                        <label for="modalProductQuantity">{{ __('cart.quantity') }}:</label>
                        <div class="update-quantity-form align-items-center d-flex">
                            <button type="button" class="btn btn-sm btn-decrease"><i class="fa fa-minus"></i></button>
                            <input type="text" id="modalProductQuantity" name="quantity" class="quantity-input" value="1">
                            <button type="button" class="btn btn-sm btn-increase"><i class="fa fa-plus"></i></button>
                            <select name="UOM" id="modalProductUOM" class="form-select ms-2" style="width: 120px;">
                                <!-- Options will be injected dynamically -->
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bubbles bubbles-grey" data-bs-dismiss="modal"><span class="text">Cancel</span></button>
                    <button type="submit" class="btn bubbles bubbles-arctic">
                        <span class="text"> <i class="fas fa-cart-plus me-2"></i>{{ __('cart.add_to_cart') }}</span>
                    </button>
                </div>
                <input type="hidden" id="modalProductId" name="product_id">
                <input type="hidden" id="modalProductShelfPrice" name="shelf_price">
                <input type="hidden" id="modalProductUnitPrice" name="unit_price">
                <input type="hidden" id="modalProductOldPrice" name="old_price">
                <input type="hidden" id="modalProductType" name="type">
                <input type="hidden" id="modalProductName" name="name">
                <input type="hidden" id="modalProductDescription" name="description">
                <input type="hidden" id="modalProductEaCa" name="ea-ca">
                <input type="hidden" id="modalProductEaPl" name="ea-pl">
                <input type="hidden" id="modalProductEa" name="ea">
                <input type="hidden" id="modalProductCa" name="ca">
                <input type="hidden" id="modalProductPl" name="pl">
            </form>
        </div>
    </div>
</div>

<style>
    /* Update Quantity Form Styling*/
    .update-quantity-form .btn,
    .update-quantity-form .quantity-input {
        position: relative;
        overflow: hidden;
        font-size: 1;
        border-radius: 0.5rem;
        background: none;
        border: none;
        color: var(--primary-text);
        transition: color 0.3s;
    }

    .update-quantity-form {
        width: fit-content;
        padding: 0 1rem;
        display: inline-block;
    }

    /* Remove default button focus outlines */
    .update-quantity-form .btn:focus,
    .update-quantity-form .btn:active {
        box-shadow: none;
        outline: none;
    }

    .update-quantity-form .btn {
        padding: 0;
    }

    .update-quantity-form .btn:hover {
        color: var(--link-hover);
    }

    /* For input underline effect on focus */
    .update-quantity-form .quantity-input {
        border: none;
        border-radius: 0.5rem;
        border-bottom: 2px solid var(--primary-text);
        text-align: center;
        font-weight: 500;
        color: var(--primary-text);
        padding: 0.25rem 0.5rem;
        width: calc(var(--card-width)*0.25);
        transition: border-color 0.3s, color 0.3s;
    }

    .update-quantity-form .quantity-input:focus {
        outline: none;
        border-color: var(--link-hover);
        color: var(--link-hover);
    }

    .update-quantity-form .quantity-input:active {
        outline: none;
        border-color: var(--link-hover);
        color: var(--link-hover);
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('addToCartModal');
        if (!modal) return;

        const quantityInput = modal.querySelector('.quantity-input');
        const btnIncrease = modal.querySelector('.btn-increase');
        const btnDecrease = modal.querySelector('.btn-decrease');

        if (!quantityInput || !btnIncrease || !btnDecrease) return;

        btnIncrease.addEventListener('click', function() {
            let val = parseInt(quantityInput.value) || 1;
            quantityInput.value = val + 1;
        });

        btnDecrease.addEventListener('click', function() {
            let val = parseInt(quantityInput.value) || 1;
            if (val > 1) quantityInput.value = val - 1;
        });

        // Optional: Prevent non-numeric input
        quantityInput.addEventListener('input', function() {
            let val = parseInt(quantityInput.value) || 1;
            if (val < 1) val = 1;
            quantityInput.value = val;
        });
    });
</script>