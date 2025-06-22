// ---------------------------------- INDEX HANDLING ---------------------------------- //
$(document).ready(function () {
    console.log('Initializing Slick Carousels');
    $('.hero-carousel').slick({
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

    $('.carousel').slick({
        centerMode: false,
        centerPadding: '0px',
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 5,
        slidesToScroll: 1,
        arrows: true,
        autoplay: true,
        autoplaySpeed: 2500,
        prevArrow: '<button type="button" class="slick-prev slick-arrow"><i class="fas fa-chevron-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next slick-arrow"><i class="fas fa-chevron-right"></i></button>',
        responsive: [{
            breakpoint: 992, // Optional: add for tablets
            settings: {
                slidesToShow: 3
            }
        },
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 2
            }
        },
        {
            breakpoint: 576,
            settings: {
                slidesToShow: 1
            }
        }
        ]
    });

    // Intercept add-to-cart button click to show modal
    $('form.add-to-cart-form').off('submit').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        let productName = form.closest('.card').find('.card__title, .card-title').text().trim();
        let productId = form.find('input[name="product_id"]').val();
        let productPrice = form.find('input[name="price"]').val();
        let productDescription = form.find('input[name="description"]').val();

        // Set modal fields
        $('#addToCartModalLabel').text(productName);
        $('#modalProductId').val(productId);
        $('#modalProductPrice').val(productPrice);
        $('#modalProductDescription').val(productDescription);
        $('#modalProductQuantity').val(1);

        // Show price and description in the modal
        $('#modalProductPriceDisplay').text('Price: $' + productPrice);
        $('#modalProductDescriptionDisplay').text(productDescription);
        
        // Show modal
        var modal = new bootstrap.Modal(document.getElementById('addToCartModal'));
        modal.show();
    });

    // Handle modal form submit
    $('#addToCartForm').off('submit').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        let button = form.find('button[type="submit"]');
        button.prop('disabled', true);

        let url = $('form.add-to-cart-form').first().attr('action'); // Use the action from any add-to-cart form
        let data = {
            product_id: $('#modalProductId').val(),
            price: $('#modalProductPrice').val(),
            description: $('#modalProductDescription').val(),
            quantity: $('#modalProductQuantity').val(),
            _token: window.csrfToken
        };

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': window.csrfToken
            },
            success: function (response) {
                button.prop('disabled', false);
                bootstrap.Modal.getInstance(document.getElementById('addToCartModal')).hide();

                // Update cart count badge
                if (response.cart_count !== undefined) {
                    $('#cart-count').text(response.cart_count);
                } else {
                    let current = parseInt($('#cart-count').text()) || 0;
                    $('#cart-count').text(current + 1);
                }
                showAjaxToast('success', window.cartMessages.addSuccess);
            },
            error: function (xhr) {
                button.prop('disabled', false);
                if (xhr.status === 401) {
                    window.location.href = window.signinUrl + '?showToast=1&toastMessage=' + encodeURIComponent('Please sign in to add items to your cart.');
                }
            }
        });
    });

    // Make cards clickable
    $('.product-card, .category-card').click(function (e) {
        // If click on a link, button, form element - do nothing
        if ($(e.target).closest('a, button, input, form').length === 0) {
            var url = $(this).data('url');
            if (url) {
                window.location.href = url;
            }
        }
    });
});