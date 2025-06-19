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
        slidesToShow: 4, // Changed from 3 to 4
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

    // AJAX Add to Cart
    $('form.add-to-cart-form').submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let url = form.attr('action');
        let data = form.serialize();

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.success) {
                    if (response.cart_count !== undefined) {
                        // Update cart count badge
                        // $('#cart-count').text(response.cart_count);
                    }

                } else { }
            },
            error: function (xhr) {
                if (xhr.status === 401) {
                    // Unauthorized - redirect to login page
                    window.location.href = "{{ route('customer.signin', ['locale' => app()->getLocale()]) }}";
                } else {

                    console.log(xhr.error);
                    alert('Error occurred while adding to cart.');
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