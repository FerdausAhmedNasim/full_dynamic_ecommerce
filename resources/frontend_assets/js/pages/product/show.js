$(document).ready(function () {
    // Quantity Plus Minus
    $(document).on('click', '.plus', function() {
        var input  = $(this).closest('.quantity').find('.qty-input');
        var maxValue =  parseInt(input.attr('max'));
        var inputValue = parseInt(input.val());

        if (inputValue < maxValue && !input.is('[readonly]')) {
            input.val(inputValue + 1);
            input.trigger('change');
        } else {
            input.val(maxValue);
        }
    });

    $('.minus').on('click', function () {
        var input  = $(this).closest('.quantity').find('.qty-input');
        var inputValue = input.val();

        if ( inputValue > 1 && !input.is('[readonly]')) {
            input.val(parseInt(inputValue) - 1);
            input.trigger('change');
        }
    });

    $(document).on('keyup', '.qty-input', function() {
        var input  = $(this).closest('.quantity').find('.qty-input');
        var minValue = parseInt($(this).attr('min'));
        var maxValue = parseInt($(this).attr('max'));
        var inputValue = $(this).val();

        if (inputValue < minValue || inputValue > maxValue) {
            $(this).val(1);
            input.trigger('change');
        }
    });

    $('.review-form').on('submit', function(event){
        event.preventDefault();

        var id = $("#product_id").val();
        const url = BASE_URL + "/products/"+id+"/review";
        var form_data = new FormData(this);

        axios.post(url, form_data)
            .then(response => {
                $('.dropMeUploader .previewImage').remove();
                $('.dropMeUploader .upload-text').css({
                    "display":"block",
                    "display": "flex",
                });
                $(".cancel").click();

                notify(response.data.msg, 'success');
            })
            .catch(error => {
                const response = error.response;

                if (response) {
                    if (response.status === 422) {
                        var error_data = '';

                        $.each(response.data.errors, function(fieldName, fieldErrors){
                            error_data += '<p class="error-message text-danger">'+fieldErrors+'</p>';
                        });

                        $("#error-msg").html(error_data);
                    } else {
                        notify(response.data.message, 'error');
                    }
                }
            })
    });

    // Add to cart button click event
    $('.btn-add-to-cart').on('click', function() {
        // Start Fly Cart
        if ($(window).width() > 768) {
            var cart = $('.button-item');
        } else {
            var cart = $('.mobile-cart ul li a .icli.fly-cate');
        }

        var imgToDrag = $(".slider-image img").eq(0);

        var cloneImage = imgToDrag.clone()
            .offset({
                top: imgToDrag.offset().top,
                left: imgToDrag.offset().left
            })
            .css({
                'opacity': '1',
                'position': 'absolute',
                'height': '130px',
                'width': '130px',
                'z-index': '100'
            })
            .appendTo($('body'))
            .animate({
                'top': cart.offset().top + 10,
                'left': cart.offset().left - 30,
                'width': 70,
                'height': 70
            }, 1000, 'easeInOutExpo');

            cloneImage.animate({
                'width': 0,
                'height': 0
            }, function () {
                $(this).detach()
            });
        // End Fly Cart

        var productId = $('input[name="product_id"]').val();
        var unitPrice = $('input[name="unit_price"]').val();
        var quantity = parseInt($('.qty-input').val());
        var ezzicoDiscount = $('input[name="ezzico_discount"]').val();
        var selectedColor = $('input[name="color"]:checked').val();
        var selectedVariants = [];

        $('input[type="radio"].attribute:checked').each(function() {
            selectedVariants.push($(this).val());
        });

        $.ajax({
            url: '/add-to-cart',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                product_id: productId,
                quantity: quantity,
                price: unitPrice,
                ezzico_discount: ezzicoDiscount,
                color: selectedColor,
                variants: selectedVariants
            },
            success: function(response) {
                var totalAmount = 0;
                var cartIcon = $('.items-image');

                cartIcon.empty();

                response.carts.forEach(function(cartItem) {
                    var itemTotal = cartItem.quantity * cartItem.price;
                    totalAmount += itemTotal;
                });

                var itemsToDisplay = response.carts.slice(0, 4); // Select only the first two items
                var remainingItemCount = Math.max(response.carts.length - 3, 0);

                itemsToDisplay.forEach(function(cartItem) {
                    var newItem = $('<li><img src="' + cartItem.thumbnail_image_url + '" alt=""></li>');
                    cartIcon.prepend(newItem);
                });

                // Side Cart
                var itemCount = response.carts.length;
                $('.item-title').text(itemCount + ' Items');

                if (remainingItemCount > 0) {
                    $('.items-image li:last').text('+' + remainingItemCount);
                } else {
                    $('.items-image li:last').text('');
                }

                $('.cart-total').text('Total: $' + totalAmount.toFixed(2));

                // Header Cart
                var headerCart = $('<span class="position-absolute top-0 start-100 translate-middle badge cartItemTotal">' + itemCount + ' <span class="visually-hidden">unread messages</span> </span>');
                $('.header-cart').append(headerCart);

                cartIcon.show();

                notify(response.message, 'success');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);

                notify('Opps! Something went wrong', 'danger');
            }
        });
    });

});


// Function to update cart data with AJAX
function addDataToCartAndRedirect() {
    var productId = $('input[name="product_id"]').val();
    var unitPrice = $('input[name="unit_price"]').val();
    var product_slug = $('input[name="product_slug"]').val();
    var quantity = parseInt($('.qty-input').val());
    var ezzicoDiscount = $('input[name="ezzico_discount"]').val();
    var selectedColor = $('input[name="color"]:checked').val();
    var selectedVariants = [];

    $('input[type="radio"].attribute:checked').each(function() {
        selectedVariants.push($(this).val());
    });

    $.ajax({
        url: '/buy-now',
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            product_id: productId,
            quantity: quantity,
            price: unitPrice,
            ezzico_discount: ezzicoDiscount,
            color: selectedColor,
            variants: selectedVariants,
            buy_now: 'buy_now',
            product_slug: product_slug,
        },
        success: function(response) {
            var guestCheckout = response.guestCheckout;
            var isAuthenticated = response.isAuthenticated;

            if (isAuthenticated || guestCheckout) {
                window.location.href = '/checkout';
            } else {
                window.location.href = '/login';
            }
        },
        error: function(xhr, status, error) {
            console.error('Error updating cart data:', error);
        }
    });
}

// Event listener for checkout button
$('#buyNow').on('click', function () {
    $(this).prop('disabled', true);

    addDataToCartAndRedirect();
});
