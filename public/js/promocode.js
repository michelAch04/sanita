document.addEventListener("DOMContentLoaded", () => {
    const applyPromoBtn = document.getElementById("applyPromoBtn");

    if (applyPromoBtn) {
        applyPromoBtn.addEventListener("click", async () => {
            const promoCode = document
                .getElementById("promo_code")
                .value.trim();

            if (!promoCode) {
                showAjaxToast("warning", "Please enter a promo code.");
                return;
            }
            const csrf = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");

            const url = window.validatePromoUrl;

            try {
                const response = await fetch(url, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrf, // CSRF token sent here
                        "X-Requested-With": "XMLHttpRequest",
                    },
                    body: JSON.stringify({ code: promoCode }),
                });

                const data = await response.json();

                if (!data.success) {
                    showAjaxToast(
                        "warning",
                        data.message || "Invalid promo code."
                    );
                } else {
                    showAjaxToast(
                        "success",
                        "Promo code applied successfully!"
                    );
                    console.log("Promo code details:", data.promo);

                    // TODO: Update UI with discount, recalculate totals, etc.
                }
            } catch (error) {
                console.error("Error validating promo code:", error);
                showAjaxToast(
                    "error",
                    "An error occurred while validating the promo code."
                );
            }
        });
    }
});
