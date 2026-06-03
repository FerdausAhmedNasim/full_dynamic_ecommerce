//  /**=====================
//      My Cart js
// ==========================**/

$('.btn-cart').on('click', function () {
    // var imgSrc = $(this).closest('.product-box-4').find(".product-thumbnail img").eq(0).attr('src');

    // var newItem = $('<li><img src="' + imgSrc + '" alt=""></li>');
    // $('.items-image').prepend(newItem);

    // var itemCount = $('.items-image li').length;
    // $('.items-image li:last').text('+' + (itemCount - 1));
    // $('.item-title').text(itemCount + ' Items');

    // $('.items-image').show();

    var cloneImage = $(this).closest('.product-box-4').find(".product-thumbnail img").eq(0).clone();

    var itemImage = $('.items-image');

    cloneImage.appendTo(itemImage);

    cloneImage.css({
        'opacity': '0.5',
        'position': 'absolute',
        'height': '130px',
        'width': '130px',
        'z-index': '100'
    }).offset({
        top: $(this).offset().top,
        left: $(this).offset().left
    }).animate({
        'top': itemImage.offset().top + 10,
        'left': itemImage.offset().left + 10,
        'width': 75,
        'height': 75
    }, 1000, 'easeInOutExpo', function () {
        $(this).detach();
    });


    // Calculate the total amount in the cart
    var totalAmount = 0;

    var price = $(this).closest('.product-box-4').find('.product_price').val();
    var quantity = $(this).closest('.product-box-4').find('.qty-input').val();

    if (!isNaN(price) && !isNaN(quantity)) {
        totalAmount += price * quantity;
    }
    $('.cart-total').text('Total: ' + totalAmount.toFixed(2));


    // Store item in database
    var productId = $(this).closest('.product-box-4').find('.product_id').val();

    $.ajax({
        url: '/add-to-cart',
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            product_id: productId,
            quantity: quantity,
            price: price
        },
        success: function (response) {
            var totalAmount = 0;
            var cartIcon = $('.items-image');
            cartIcon.empty();

            response.carts.forEach(function(cartItem) {
                var newItem = $('<li><img src="' + cartItem.thumbnail_image_url + '" alt=""></li>');
                cartIcon.prepend(newItem);

                var itemTotal = cartItem.quantity * cartItem.price;
                totalAmount += itemTotal;


            });

            var itemCount = $('.items-image li').length;
            $('.items-image li:last').text('+' + itemCount);
            $('.item-title').text(itemCount + ' Items');
            $('.cart-total').text('Total: ' + totalAmount.toFixed(2));

            cartIcon.show();

            console.log(response.message);

            // notify(response.message, 'success');
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
            // notify(xhr.responseText, 'error');
        }
    });

    $(this).closest('.product-box-4').find('.qty-input').val(1);
});


/** ----------------------------------------------------------
    Quantity Checking with Increment & Decrement 
---------------------------------------------------------- **/

$(".addcart-button").click(function () {
    $(this).next().addClass("open");
    $(".add-to-cart-box .qty-input").val('1');
});

$('.add-to-cart-box').on('click', function () {
    var $qty = $(this).siblings(".qty-input");
    var currentVal = parseInt($qty.val());
    if (!isNaN(currentVal)) {
        $qty.val(currentVal + 1);
    }
});

$('.qty-input').on('input', function() {
    var current_stock = $(this).closest('.product-box-4').find('.current_stock').val();
    var quantity = parseInt($(this).val());

    if (quantity < 1 || isNaN(quantity)) {
        $(this).val(1);
    } else if (quantity > current_stock) {
        $(this).val(current_stock);
    }
});

$('.qty-left-minus').on('click', function () {
    var $qty = $(this).siblings(".qty-input");
    var currentVal = parseInt($qty.val());

    if (!isNaN(currentVal) && currentVal > 1) {
        $qty.val(currentVal - 1);
    }

    if ($qty.val() == '1') {
        $(this).parents('.cart_qty').removeClass("open");
    }
});

$('.qty-right-plus').click(function () {
    var current_stock = $(this).closest('.product-box-4').find('.current_stock').val();

    var $qty = $(this).siblings(".qty-input");
    var currentVal = parseInt($qty.val());

    if (currentVal < current_stock) {
        $(this).prev().val(+$(this).prev().val() + 1);
    }
});
