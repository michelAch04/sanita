document.addEventListener("DOMContentLoaded", () => {
    const applyPromoBtn = document.getElementById("applyPromoBtn");
    const promoInput = document.getElementById("promo_code");
    const discountRow = document.getElementById("discountRow");
    const discountAmountField = document.getElementById("discountAmount");
    const finalTotalField = document.getElementById("finalTotal");

    const csrf = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    let promoApplied = false;
    let originalTotal = window.originalTotal;
    let applybtn = window.applybtn;
    let removebtn = window.removebtn;

    if (applyPromoBtn) {
        applyPromoBtn.addEventListener("click", async () => {
            const code = promoInput.value.trim();

            if (!code) {
                showAjaxToast("warning", "Please enter a promo code.");
                return;
            }

            const url = promoApplied
                ? window.removePromoUrl
                : window.validatePromoUrl;

            const payload = { code, cart_total: originalTotal };

            try {
                const response = await fetch(url, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrf,
                        "X-Requested-With": "XMLHttpRequest",
                    },
                    body: JSON.stringify(payload),
                });

                const data = await response.json();

                if (!data.success) {
                    showAjaxToast("warning", data.message || "Promo failed.");
                    return;
                }

                if (promoApplied) {
                    // Reset totals
                    finalTotalField.textContent = originalTotal.toFixed(2);
                    discountAmountField.textContent = "0.00";
                    discountRow.style.display = "none";
                    applyPromoBtn.textContent = applybtn;
                    promoApplied = false;
                    showAjaxToast("info", "Promo code removed.");
                } else {
                    // Apply discount
                    discountAmountField.textContent = data.discount_amount;
                    finalTotalField.textContent = data.discounted_total;
                    discountRow.style.display = "block";
                    applyPromoBtn.textContent = removebtn;
                    promoApplied = true;
                    showAjaxToast("success", "Promo code applied!");
                }
            } catch (error) {
                console.error("Promo error:", error);
                showAjaxToast("error", "Something went wrong.");
            }
        });
    }
});
