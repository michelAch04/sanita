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
            // Store for use in the modal or product page
            if (window.isProductPage) {
                $("#productPageForm").data("minQuantities", minQuantities);
                $("#productPageForm").data("maxQuantities", maxQuantities);
                $("#productPageForm").data("unitPrices", unitPrices);
                $("#productPageForm").data("shelfPrices", shelfPrices);
                $("#productPageForm").data("oldPrices", oldPrices);
            }
            else {
                $("#addToCartModal").data("minQuantities", minQuantities);
                $("#addToCartModal").data("maxQuantities", maxQuantities);
                $("#addToCartModal").data("unitPrices", unitPrices);
                $("#addToCartModal").data("shelfPrices", shelfPrices);
                $("#addToCartModal").data("oldPrices", oldPrices);
            }
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
            let radiosContainer = $("#modalProductUOMRadios");
            if (radiosContainer) {
                radiosContainer.empty();
                availableUOMs.forEach((uom, idx) => {
                    let label = window.uomLabels[uom] || uom;
                    radiosContainer.append(`
                    <label class="select-label">
                        <input type="radio" name="UOM" value="${uom}" ${idx === 0 ? "checked" : ""}>
                        <span>${label}</span>
                    </label>
                `);
                });
            }

            const addToCartModal = document.getElementById("addToCartModal");
            if (addToCartModal) {
                // Show modal
                var modal = new bootstrap.Modal(
                    addToCartModal
                );
                modal.show();
            }
            $('input[name="UOM"]:checked').trigger("change");
        });

    if (window.isProductPage) {
        const loadForm = $('.add-to-cart-form');
        loadForm.trigger('submit');
    }

    $("#addToCartSubmit").on("click", function (e) {
        e.preventDefault();
        $("#addToCartForm").trigger("submit");
    })
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
                    .replace(/[^\d.]/g, ""),
                type: $("#modalProductType").val(),
                ea_ca: $("#modalProductEaCa").val(),
                ea_pl: $("#modalProductEaPl").val(),
                unit: $('input[name="UOM"]:checked').val() || "EA",
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
                    if ($("#addToCartModal").length) {
                        bootstrap.Modal.getInstance(
                            document.getElementById("addToCartModal")
                        ).hide();
                    }

                    // Update cart count badge
                    if (response.cart_count !== undefined) {
                        $("#cart-count").text(response.cart_count);
                    } else {
                        let current = parseInt($("#cart-count").text()) || 0;
                        $("#cart-count").text(current + 1);
                    }

                    // Build the "View in Cart" button (same as in Blade)
                    let productId = $("#modalProductId").val();
                    let productCardForm, viewCartButton;
                    if ($("#addToCartModal").length) {
                        productCardForm = $(`form.add-to-cart-form input[name="product_id"][value="${productId}"]`).closest("form");
                        viewCartButton = `
                            <a href="${window.url}/${window.locale}/cart" class="card__button card__button-incart">
                                <i class="fas fa-shopping-cart"></i> ${window.cartMessages.viewInCart}
                            </a>
                        `;
                    }
                    else {
                        productCardForm = $("#addToCartSubmit");
                        viewCartButton = `<a href="${window.url}/${window.locale}/cart" class="btn btn-success" id="addToCartSubmit">
                            <i class="fas fa-shopping-cart me-1"></i> ${window.cartMessages.viewInCart}
                        </a>`;
                    }

                    if (productCardForm.length) {
                        productCardForm.replaceWith(viewCartButton);
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
    $(document)
        .off("change", "input[name='UOM']")
        .on("change", "input[name='UOM']", function () {
            let selectedUOM = $(this).val();
            let container = window.isProductPage ? $("#productPageForm") : $("#addToCartModal");
            let unitPrices = container.data("unitPrices") || {};
            let shelfPrices = container.data("shelfPrices") || {};
            let oldPrices = container.data("oldPrices") || {};
            let minQuantities = container.data("minQuantities") || {};
            let maxQuantities = container.data("maxQuantities") || {};

            // Update price fields
            let unitPrice = unitPrices[selectedUOM] || unitPrices["EA"] || "";
            let shelfPrice =
                shelfPrices[selectedUOM] || shelfPrices["EA"] || "";
            let oldPrice = oldPrices[selectedUOM] || oldPrices["EA"] || "";

            $("#modalProductUnitPrice").val(unitPrice);
            $("#modalProductShelfPrice").text("$" + shelfPrice);

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
            let maxqty =
                maxQuantities[selectedUOM] || maxQuantities["EA"] || "";
            $("#modalProductMinQuantity").val(minqty);
            $("#modalProductMaxQuantity").val(maxqty);
            $("#modalProductQuantity").val(minqty).trigger('input');

            // Update conversion field
            let ea_ca = $("#modalProductEaCa").val();
            let ea_pl = $("#modalProductEaPl").val();
            let conversionText = "";

            if (selectedUOM === "CA" && ea_ca) {
                conversionText = window.conversionCaseEach.replace(":count", ea_ca);
            } else if (selectedUOM === "PL" && ea_pl) {
                conversionText = window.conversionPalletEach.replace(":count", ea_pl);
            } else if (selectedUOM === "EA") {
                conversionText = "";
            }

            $("#modalProductConversion").text(conversionText);
            $("#conversionText").text(conversionText);
        });

    // ------------------------------------ NAVBAR SCROLL --------------------------------------- //
    // let lastScroll = 0;
    // let navbar = document.getElementById('mainNavbar');
    // let isScrolling;

    // window.addEventListener('scroll', function () {
    //     const currentScroll = window.pageYOffset || document.documentElement.scrollTop;

    //     // Hide navbar if scrolling down
    //     if (currentScroll > lastScroll && currentScroll > 50) {
    //         navbar.style.transform = 'translateY(-100%)';
    //     } else {
    //         navbar.style.transform = 'translateY(0)';
    //     }

    //     lastScroll = currentScroll <= 0 ? 0 : currentScroll;

    //     // Show navbar if scrolling stops
    //     clearTimeout(isScrolling);
    //     isScrolling = setTimeout(() => {
    //         navbar.style.transform = 'translateY(0)';
    //     }, 300); // after scroll stops
    // });

    // ------------------------------------ SEARCH BAR ------------------------------------------ //
    const searchInput = document.getElementById("searchInput");
    const searchIcon = searchInput.previousElementSibling;
    const rightIconsContainer = searchInput.closest('.right-icons-container');

    searchInput.addEventListener("focus", () => {
        searchInput.classList.add("expanded");
        searchIcon.classList.add('focused');
        rightIconsContainer.classList.add("search-focused");
    });

    searchInput.addEventListener("blur", () => {
        if (searchInput.value.trim() === "") {
            searchInput.classList.remove("expanded");
            searchIcon.classList.remove('focused');
            rightIconsContainer.classList.remove("search-focused");
        }
    });

    searchInput.addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            const q = this.value.trim();
            if (q) {
                window.location.href = window.url + `/${window.locale}/search?q=${encodeURIComponent(q)}`;
            }
        }
    });

    document.getElementById("menuToggle").addEventListener("click", () => {
        const offcanvas = new bootstrap.Offcanvas(document.getElementById("offcanvasMenu"));
        offcanvas.show();
    });
});