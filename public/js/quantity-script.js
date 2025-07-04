document.addEventListener('DOMContentLoaded', function () {
    function showQuantityWarning(message) {
        if (typeof showAjaxToast === "function") {
            showAjaxToast('warning', message);
        } else {
            alert(message); // fallback
        }
    }

    // Allow multiple forms to have their own quantity controls
    document.querySelectorAll('.update-quantity-form').forEach(function () {
        const quantityInput = document.querySelector('.quantity-input');
        const btnIncrease = document.querySelector('.btn-increase');
        const btnDecrease = document.querySelector('.btn-decrease');

        // Try to find the related hidden min/max inside same form or fallback
        const minEl = document.querySelector('#modalProductMinQuantity');
        const maxEl = document.querySelector('#modalProductMaxQuantity');

        const getMin = () => parseInt(minEl?.value || 1);
        const getMax = () => parseInt(maxEl?.value || 0);

        btnIncrease?.addEventListener('click', () => {
            let val = parseInt(quantityInput.value) || getMin();
            if (getMax() && val + 1 > getMax()) {
                quantityInput.value = getMax();
                showQuantityWarning("Cannot increase above max: " + getMax());
            } else {
                quantityInput.value = val + 1;
            }
        });

        btnDecrease?.addEventListener('click', () => {
            let val = parseInt(quantityInput.value) || getMin();
            if (val - 1 < getMin()) {
                quantityInput.value = getMin();
                showQuantityWarning("Cannot decrease below min: " + getMin());
            } else {
                quantityInput.value = val - 1;
            }
        });

        quantityInput?.addEventListener('blur', () => {
            let val = parseInt(quantityInput.value) || getMin();
            if (val < getMin()) {
                quantityInput.value = getMin();
                showQuantityWarning("Minimum: " + getMin());
            } else if (getMax() && val > getMax()) {
                quantityInput.value = getMax();
                showQuantityWarning("Maximum: " + getMax());
            }
        });
    });
});