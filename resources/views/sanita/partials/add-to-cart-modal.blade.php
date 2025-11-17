{{-- Add to Cart Modal --}}
<div class="modal fade {{ $isRtl ? 'rtl-container' : '' }}" id="addToCartModal" tabindex="-1" aria-labelledby="addToCartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header text-white">
                <h5 class="modal-title" id="addToCartModalLabel">Add to Cart</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addToCartForm">
                <div class="modal-body">
                    <div class="mb-2">
                        <span id="modalProductDescriptionDisplay" class="text-muted"></span>
                    </div>
                    <div class="mb-2">
                        <span id="modalProductOldPriceDisplay" class="text-muted text-decoration-line-through me-2 d-none"></span>
                        <span id="modalProductShelfPriceDisplay" class="fw-bold"></span>
                    </div>
                    <div class="select-container position-relative align-items-start d-flex flex-column mt-1">
                        <label>{{ __('cart.order-per') }}:</label>
                        <div id="modalProductUOMRadios"></div>
                    </div>
                    <div id="modalProductConversion" class="mb-1 mt-1 text-muted small"></div>
                    <div class="mt-3">
                        <label for="modalProductQuantity">{{ __('cart.quantity') }}:</label>
                        <div class="update-quantity-form align-items-center d-flex mb-2">
                            <button type="button" class="btn btn-sm btn-decrease"><i class="fa fa-minus"></i></button>
                            <input type="text" id="modalProductQuantity" name="quantity" class="quantity-input">
                            <button type="button" class="btn btn-sm btn-increase"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bubbles bubbles-grey" data-bs-dismiss="modal"><span class="text">{{__( 'nav.cancel' )}}</span></button>
                        <button type="submit" class="btn bubbles bubbles-arctic">
                            <span class="text"> <i class="fas fa-cart-plus me-2"></i>{{ __('cart.add_to_cart') }}</span>
                        </button>
                    </div>
                    @include('sanita.partials.add-to-cart-needs')
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .modal-header {
        background: var(--primary-blue);
    }

    #modalProductShelfPrice {
        color: var(--primary-text);
    }

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

    /* SELECT CONTAINER STYLING */
    .select-container:focus,
    .select-label:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 4px var(--secondary-blue);
    }

    .select-container input[type="radio"]:checked+span {
        box-shadow: 0 0 0 0.0625em var(--primary-blue);
        background-color: var(--hover-blue);
        z-index: 1;
        color: var(--primary-text);
    }

    .select-label span {
        background-color: var(--card-bg);
        color: var(--primary-text);
    }
</style>
<script src="{{ asset('js/quantity-script.js') }}"></script>