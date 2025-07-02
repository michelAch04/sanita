document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = window.csrfToken;

    const recalculateCartTotal = () => {
        let total = 0;
        document.querySelectorAll('[data-id] .total-price').forEach(el => {
            const val = parseFloat(el.textContent.replace('$', ''));
            if (!isNaN(val)) total += val;
        });
        document.getElementById('cart-total').textContent = `$${total.toFixed(2)}`;
    };

    document.querySelectorAll('.update-quantity-form').forEach(form => {
        const input = form.querySelector('.quantity-input');
        const id = form.closest('.cart-item')?.dataset.id;
        if (!id) return;
        let originalValue = parseInt(input.value || 1);

        const sendQuantityUpdate = (quantity) => {
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    _method: 'PUT',
                    quantity
                })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        input.value = data.quantity;
                        originalValue = data.quantity;

                        // Update the total price display
                        const totalPriceEl = document.querySelector(`[data-id="${id}"] .total-price`);
                        if (totalPriceEl) {
                            totalPriceEl.textContent = `$${Number(data.item_total).toFixed(2)}`;;
                        }

                        recalculateCartTotal();
                        showAjaxToast('success', window.cartMessages.updateSuccess);
                    } else {
                        input.value = originalValue;
                        showAjaxToast('failed', window.cartMessages.updateFailed + ' ' + (data.message || ''));
                    }
                })
                .catch(() => {
                    input.value = originalValue;
                    showAjaxToast('failed', window.cartMessages.updateError);
                });
        };

        form.querySelector('.btn-increase')?.addEventListener('click', () => {
            const newQty = parseInt(input.value || 1) + 1;
            sendQuantityUpdate(newQty);
        });

        form.querySelector('.btn-decrease')?.addEventListener('click', () => {
            const currentVal = parseInt(input.value || 1);
            if (currentVal > 1) {
                sendQuantityUpdate(currentVal - 1);
            }
        });

        input.addEventListener('focus', () => {
            originalValue = parseInt(input.value || 1);
        });

        input.addEventListener('blur', () => {
            const newQty = parseInt(input.value || 1);
            if (originalValue !== newQty && !isNaN(newQty) && newQty > 0) {
                sendQuantityUpdate(newQty);
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault(); // Prevent form submission on Enter
                input.blur(); // Optionally trigger blur to submit update
            }
        });
    });

    document.querySelectorAll('.delete-item-form').forEach(form => {
        const id = form.closest('.cart-item')?.dataset.id;
        if (!id) return;
        form.querySelector('.delete-item-btn').addEventListener('click', (e) => {
            e.preventDefault();

            // Set the form action in the modal
            const modalForm = document.getElementById('deleteForm');
            modalForm.action = form.action;

            // Show the modal
            const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('deleteModal'));
            modal.show();

            // Remove any previous event listeners to avoid duplicates
            modalForm.onclick = null;

            // When the modal's delete button is clicked, submit via AJAX
            modalForm.onsubmit = function (event) {
                event.preventDefault();

                fetch(modalForm.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        _method: 'DELETE'
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        modal.hide();
                        if (data.success) {
                            const itemRow = document.querySelector(`[data-id="${id}"]`);
                            if (itemRow) itemRow.remove();

                            recalculateCartTotal();

                            if (document.querySelectorAll('[data-id]').length === 0) {
                                showAjaxToast('success', window.cartMessages.removeSuccess);
                                setTimeout(() => location.reload(), 1000);
                            } else {
                                showAjaxToast('success', window.cartMessages.removeSuccess);
                            }
                        } else {
                            showAjaxToast('failed', window.cartMessages.removeFailed + (data.message || ''));
                        }
                    })
                    .catch(() => {
                        modal.hide();
                        showAjaxToast('failed', window.cartMessages.removeError);
                    });
            };
        });
    });
});



