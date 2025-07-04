document.addEventListener('DOMContentLoaded', function () {

    const quantity = document.getElementById('modalProductQuantity');
    const productConversion = document.getElementById('modalProductConversion');
    const shelfPrice = document.getElementById('modalProductShelfPrice');
    const oldPrice = document.getElementById('modalProductOldPriceDisplay');
    
    // Helper to update the visible fields
    function updateField(fieldId, value, prefix = '') {
        const el = document.getElementById(fieldId);
        if (el) {
            el.textContent = prefix + value;
        }
    }

    // Quantity
    if (quantity) {
        quantity.addEventListener('input', function () {
            document.querySelector('.quantity-input').value = this.value;
        });
    }

    // Product Conversion
    if (productConversion) {
        productConversion.addEventListener('input', function () {
            updateField('conversionText', this.value);
        });
    }

    // Shelf Price
    if (shelfPrice) {
        shelfPrice.addEventListener('input', function () {
            updateField('shelfPrice', this.value, '$');
        });
    }

    // Old Price
    if (oldPrice) {
        oldPrice.addEventListener('input', function () {
            const value = this.value;
            if (value && parseFloat(value) > 0) {
                updateField('oldPrice', value, '$');
                document.getElementById('oldPrice').style.display = 'inline';
            } else {
                document.getElementById('oldPrice').style.display = 'none';
            }
        });
    }

    document.querySelectorAll('input[name="UOM"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            const uom = this.value;
            const prices = window.productPrices[uom];
            if (!prices) return;

            // Update new price
            document.getElementById('shelfPrice').textContent = '$' + parseFloat(prices.shelf_price).toFixed(2);
            document.getElementById('modalProductShelfPrice').value = prices.shelf_price;

            // Update old price
            const oldPriceSpan = document.getElementById('oldPrice');
            if (prices.old_price && parseFloat(prices.old_price) > parseFloat(prices.shelf_price)) {
                oldPriceSpan.textContent = '$' + parseFloat(prices.old_price).toFixed(2);
                oldPriceSpan.style.display = 'inline';
            } else {
                oldPriceSpan.style.display = 'none';
            }
        });
    });
});