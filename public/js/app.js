// ---------------------------------- INDEX HANDLING ---------------------------------- //
$(document).ready(function () {
    // Slick carousels
    $(".hero-carousel").slick({
        dots: false,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
        arrows: false,
        draggable: true,
        swipe: true,
    });
    $(".carousel").slick({
        centerMode: false,
        centerPadding: "0px",
        dots: false,
        infinite: true,
        draggable: true,
        swipe: true,
        speed: 300,
        slidesToShow: 5,
        slidesToScroll: 1,
        arrows: true,
        autoplay: true,
        autoplaySpeed: 2500,
        prevArrow:
            '<button type="button" class="slick-prev slick-arrow"><i class="fas fa-chevron-left"></i></button>',
        nextArrow:
            '<button type="button" class="slick-next slick-arrow"><i class="fas fa-chevron-right"></i></button>',
        responsive: [
            {
                breakpoint: 992,
                settings: { slidesToShow: 3 },
            },
            {
                breakpoint: 768,
                settings: { slidesToShow: 2 },
            },
            {
                breakpoint: 576,
                settings: { slidesToShow: 1 },
            },
        ],
    });

    // Intercept add-to-cart button click to show modal
    $("form.add-to-cart-form")
        .off("submit")
        .on("submit", function (e) {
            e.preventDefault();
            let form = $(this);
            let productName = form
                .closest(".card")
                .find(".card__title, .card-title")
                .text()
                .trim();
            let productId = form.find('input[name="product_id"]').val();
            let unitPrices = {
                EA: form.find('input[name="unit_price"]').val(),
                CA: form.find('input[name="unit_price_ca"]').val(),
                PL: form.find('input[name="unit_price_pl"]').val(),
            };
            let shelfPrices = {
                EA: form.find('input[name="shelf_price"]').val(),
                CA: form.find('input[name="shelf_price_ca"]').val(),
                PL: form.find('input[name="shelf_price_pl"]').val(),
            };
            let oldPrices = {
                EA: form.find('input[name="old_price"]').val(),
                CA: form.find('input[name="old_price_ca"]').val(),
                PL: form.find('input[name="old_price_pl"]').val(),
            };
            let minQuantities = {
                EA: form.find('input[name="min_quantity"]').val(),
                CA: form.find('input[name="min_quantity_ca"]').val(),
                PL: form.find('input[name="min_quantity_pl"]').val(),
            };
            let maxQuantities = {
                EA: form.find('input[name="max_quantity"]').val(),
                CA: form.find('input[name="max_quantity_ca"]').val(),
                PL: form.find('input[name="max_quantity_pl"]').val(),
            };
            // Store for use in the modal
            $("#addToCartModal").data("minQuantities", minQuantities);
            $("#addToCartModal").data("maxQuantities", maxQuantities);
            $("#addToCartModal").data("unitPrices", unitPrices);
            $("#addToCartModal").data("shelfPrices", shelfPrices);
            $("#addToCartModal").data("oldPrices", oldPrices);
            let producttype = form.find('input[name="type"]').val();
            let productDescription = form
                .find('input[name="description"]')
                .val();
            let productEaCa = form.find('input[name="ea-ca"]').val();
            let productEaPl = form.find('input[name="ea-pl"]').val();

            // Default to EA or first available UOM
            let availableUOMs = JSON.parse(
                form.attr("data-available-uoms") || "[]"
            );
            let defaultUOM = availableUOMs[0] || "EA";
            let productUnitPrice = unitPrices[defaultUOM] || "";
            let productShelfPrice = shelfPrices[defaultUOM] || "";
            let productOldPrice = oldPrices[defaultUOM] || "";
            let productminqty = form.find('input[name="min_quantity"]').val();
            let productmaxqty = form.find('input[name="max_quantity"]').val();

            // Set modal fields
            $("#addToCartModalLabel").text(productName);
            $("#modalProductId").val(productId);
            $("#modalProductUnitPrice").val(productUnitPrice);
            $("#modalProductDescription").val(productDescription);
            $("#modalProductOldPrice").val(productOldPrice);
            $("#modalProductType").val(producttype);
            $("#modalProductEaCa").val(productEaCa);
            $("#modalProductEaPl").val(productEaPl);
            $("#modalProductMinQuantity").val(productminqty);
            $("#modalProductMaxQuantity").val(productmaxqty);
            $("#modalProductQuantity").val(productminqty || 1);
            $("#modalProductDescriptionDisplay").text(productDescription);
            $("#modalProductEaCa").val(productEaCa);
            $("#modalProductEaPl").val(productEaPl);

            // Show price and description in the modal
            $("#modalProductShelfPrice").text("Price: $" + productShelfPrice);

            // Show old price only if it exists and is greater than shelf price
            if (
                productOldPrice &&
                parseFloat(productOldPrice) > parseFloat(productShelfPrice)
            ) {
                $("#modalProductOldPriceDisplay")
                    .text("Old: $" + parseFloat(productOldPrice).toFixed(2))
                    .show();
            } else {
                $("#modalProductOldPriceDisplay").hide();
            }

            // Sort UOMs: EA first, then CA, then PL
            const uomOrder = ["EA", "CA", "PL"];
            availableUOMs.sort((a, b) => {
                let ia = uomOrder.indexOf(a);
                let ib = uomOrder.indexOf(b);
                ia = ia === -1 ? 99 : ia;
                ib = ib === -1 ? 99 : ib;
                return ia - ib;
            });

            // Populate UOM select dynamically
            let uomSelect = $("#modalProductUOM");
            uomSelect.empty();
            availableUOMs.forEach((uom) => {
                uomSelect.append(`<option value="${uom}">${uom}</option>`);
            });

            // Show modal
            var modal = new bootstrap.Modal(
                document.getElementById("addToCartModal")
            );
            modal.show();
            $("#modalProductUOM").trigger("change");
        });

    // Handle modal form submit
    $("#addToCartForm")
        .off("submit")
        .on("submit", function (e) {
            e.preventDefault();
            let form = $(this);
            let button = form.find('button[type="submit"]');
            button.prop("disabled", true);

            let url = $("form.add-to-cart-form").first().attr("action");
            let data = {
                product_id: $("#modalProductId").val(),
                description: $("#modalProductDescription").val(),
                quantity: $("#modalProductQuantity").val(),
                old_price: $("#modalProductOldPrice").val(),
                unit_price: $("#modalProductUnitPrice").val(),
                shelf_price: $("#modalProductShelfPrice")
                    .text()
                    .replace("Price: $", ""),
                type: $("#modalProductType").val(),
                ea_ca: $("#modalProductEaCa").val(),
                ea_pl: $("#modalProductEaPl").val(),
                unit: $("#modalProductUOM").val() || "EA",
            };
            console.log(data);

            $.ajax({
                url: url,
                method: "POST",
                data: data,
                headers: {
                    "X-CSRF-TOKEN": window.csrfToken,
                },
                success: function (response) {
                    button.prop("disabled", false);
                    bootstrap.Modal.getInstance(
                        document.getElementById("addToCartModal")
                    ).hide();

                    // Update cart count badge
                    if (response.cart_count !== undefined) {
                        $("#cart-count").text(response.cart_count);
                    } else {
                        let current = parseInt($("#cart-count").text()) || 0;
                        $("#cart-count").text(current + 1);
                    }
                    showAjaxToast("success", window.cartMessages.addSuccess);
                },
                error: function (xhr) {
                    button.prop("disabled", false);
                    if (xhr.status === 401) {
                        window.location.href =
                            window.signinUrl +
                            "?showToast=1&toastMessage=" +
                            encodeURIComponent(
                                "Please sign in to add items to your cart."
                            );
                    }
                },
            });
        });

    // Make cards clickable
    $(".product-card, .category-card").click(function (e) {
        if ($(e.target).closest("a, button, input, form").length === 0) {
            var url = $(this).data("url");
            if (url) {
                window.location.href = url;
            }
        }
    });

    // Dynamic UOM price update in modal
    $("#addToCartModal")
        .off("change", "#modalProductUOM")
        .on("change", "#modalProductUOM", function () {
            let selectedUOM = $(this).val();
            let modal = $("#addToCartModal");
            let unitPrices = modal.data("unitPrices") || {};
            let shelfPrices = modal.data("shelfPrices") || {};
            let oldPrices = modal.data("oldPrices") || {};
            let minQuantities = modal.data("minQuantities") || {};
            let maxQuantities = modal.data("maxQuantities") || {};

            // Update price fields
            let unitPrice = unitPrices[selectedUOM] || unitPrices["EA"] || "";
            let shelfPrice =
                shelfPrices[selectedUOM] || shelfPrices["EA"] || "";
            let oldPrice = oldPrices[selectedUOM] || oldPrices["EA"] || "";

            $("#modalProductUnitPrice").val(unitPrice);
            $("#modalProductShelfPrice").text(shelfPrice);

            // Show old price only if it exists and is greater than shelf price
            if (oldPrice && parseFloat(oldPrice) > parseFloat(shelfPrice)) {
                $("#modalProductOldPriceDisplay")
                    .text("$" + parseFloat(oldPrice).toFixed(2))
                    .show();
            } else {
                $("#modalProductOldPriceDisplay").hide();
            }

            // Update min/max quantity fields
            let minqty = minQuantities[selectedUOM] || minQuantities["EA"] || 1;
            let maxqty = maxQuantities[selectedUOM] || maxQuantities["EA"] || "";
            $("#modalProductMinQuantity").val(minqty);
            $("#modalProductMaxQuantity").val(maxqty);
            $("#modalProductQuantity").val(minqty);

            // Update conversion field
            let ea_ca = $("#modalProductEaCa").val();
            let ea_pl = $("#modalProductEaPl").val();
            let conversionText = "";

            if (selectedUOM === "CA" && ea_ca) {
                conversionText = `1 CA = ${ea_ca} EA`;
            } else if (selectedUOM === "PL" && ea_pl) {
                conversionText = `1 PL = ${ea_pl} EA`;
            } else if (selectedUOM === "EA") {
                conversionText = "";
            }

            $("#modalProductConversion").text(conversionText);
        });
});
