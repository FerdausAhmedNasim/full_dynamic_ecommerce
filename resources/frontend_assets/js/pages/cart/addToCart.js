//  /**=====================
//      My Cart js
// ==========================**/

$(document).on("click",".btn-cart",function() {
    // Start Fly Cart
    if ($(window).width() > 768) {
        var cart = $('.button-item');
    } else {
        var cart = $('.mobile-cart ul li a .icli.fly-cate');
    }

    var imgToDrag = $(this).closest('.product-box-4').find(".product-image img").eq(0)
    var cloneImage = imgToDrag.clone()
    .offset({
        top: imgToDrag.offset().top,
        left: imgToDrag.offset().left
    })
    .css({
        'opacity': '0.5',
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

    // Calculate the total amount in the cart
    var totalAmount = 0;

    var price = $(this).closest('.product-box-4').find('.product_price').val();
    var quantity = $(this).closest('.product-box-4').find('.qty-input').val();
    var ezzico_discount = $(this).closest('.product-box-4').find('.ezzico_discount').val();

    console.log(ezzico_discount);

    // return;

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
            price: price,
            ezzico_discount: ezzico_discount,
        },
        success: function (response) {
            var totalAmount = 0;
            var cartIcon = $('.items-image');
            cartIcon.empty();

            response.carts.forEach(function(cartItem) {
                var itemTotal = cartItem.quantity * cartItem.price - cartItem.quantity * cartItem.ezzico_discount;
                totalAmount += itemTotal;
            });

            var itemsToDisplay = response.carts.slice(0, 4); // Select only the first 4 items
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
        error: function (xhr, status, error) {
            notify('Opps! Something went wrong', 'danger');
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

$(document).on("click",".add-to-cart-box",function() {
// $('.add-to-cart-box').on('click', function () {
    var $qty = $(this).siblings(".qty-input");
    var currentVal = parseInt($qty.val());
    if (!isNaN(currentVal)) {
        $qty.val(currentVal + 1);
    }
});

$(document).on("input",".qty-input",function() {
//$('.qty-input').on('input', function() {
    var current_stock = $(this).closest('.product-box-4').find('.current_stock').val();
    var quantity = parseInt($(this).val());

    if (quantity < 1 || isNaN(quantity)) {
        $(this).val(1);
    } else if (quantity > current_stock) {
        $(this).val(current_stock);
    }
});

$(document).on("click",".qty-left-minus",function() {
    var $qty = $(this).siblings(".qty-input");
    var currentVal = parseInt($qty.val());

    if (!isNaN(currentVal) && currentVal > 1) {
        $qty.val(currentVal - 1);
    }

    if ($qty.val() == '1') {
        $(this).parents('.cart_qty').removeClass("open");
    }
});

$(document).on("click",".qty-right-plus",function() {
    var current_stock = $(this).closest('.product-box-4').find('.current_stock').val();

    var $qty = $(this).siblings(".qty-input");
    var currentVal = parseInt($qty.val());

    if (currentVal < current_stock) {
        $(this).prev().val(+$(this).prev().val() + 1);
    }
});
