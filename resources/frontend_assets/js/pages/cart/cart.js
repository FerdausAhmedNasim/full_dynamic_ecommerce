$(window).on('pageshow', function(event) {
    if (event.originalEvent.persisted) {
        window.location.reload();
    }
});

function calculateCartTotal() {
    var subtotal = 0;

    $('.cartItems').not('.removed-item').each(function() {
        var itemTotal = parseFloat($(this).find('.item-total').text().replace(/[^\d.-]/g, ''));

        subtotal += itemTotal;
    });

    var shippingCost = 0.00;

    var total = subtotal + shippingCost;

    // Update the subtotal, coupon discount, shipping, and total on the page
    $('.subtotal .price').text('৳' + subtotal.toFixed(2));
    $('.shipping .price').text('৳' + shippingCost.toFixed(2));
    $('.cartTotal .price').text('৳' + total.toFixed(2));

    if (total > 0) {
        $("#checkoutButton").removeAttr('disabled', 'disabled');
    } else {
        $("#checkoutButton").attr('disabled', true)
    }
}

// Call the function initially to calculate and update the cart total
calculateCartTotal();

// Event listeners for quantity input changes
$('.qty-input').on('input', function() {
    var current_stock = $(this).closest('tr').find('.current_stock').val();

    var quantity = parseInt($(this).val());

    if (quantity < 1 || isNaN(quantity)) {
        $(this).val(1);
        quantity = 1;
    } else if (quantity > current_stock) {
        $(this).val(current_stock);
        quantity = parseInt(current_stock);
    }

    var price = $(this).closest('tr').find('.unitPrice').val();

    var itemTotal = calculateItemTotal(price, quantity);

    $(this).closest('tr').find('.item-total').text(itemTotal);

    // Recalculate cart total after quantity change
    calculateCartTotal();
});

// Event listener for quantity decrease button
$('.qty-left-minus').on('click', function () {
    var $qty = $(this).siblings(".qty-input");
    var currentVal = parseInt($qty.val());

    if (!isNaN(currentVal) && currentVal > 1) {
        $qty.val(currentVal - 1);
    }

    if ($qty.val() == '1') {
        $(this).parents('.cart_qty').removeClass("open");
    }

    var price = $(this).closest('tr').find('.unitPrice').val();
    var quantity = $(this).siblings(".qty-input").val();

    var itemTotal = calculateItemTotal(price, quantity);

    $(this).closest('tr').find('.item-total').text(`৳${itemTotal}`);

    // Recalculate cart total after quantity change
    calculateCartTotal();
});

// Event listener for quantity increase button
$('.qty-right-plus').click(function () {
    var price = $(this).closest('tr').find('.unitPrice').val();
    var current_stock = $(this).closest('tr').find('.current_stock').val();

    var $qty = $(this).siblings(".qty-input");
    var currentVal = parseInt($qty.val());

    if (currentVal < current_stock) {
        $(this).prev().val(+$(this).prev().val() + 1);
    }

    var quantity = parseInt($(this).prev().val());

    var itemTotal = calculateItemTotal(price, quantity);

    $(this).closest('tr').find('.item-total').text(`৳${itemTotal}`);

    // Recalculate cart total after quantity change
    calculateCartTotal();
});

// Function to calculate item total and format it as currency
function calculateItemTotal(price, quantity) {
    var itemTotal = 0;

    itemTotal = price * quantity;

    var formattedItemTotal = itemTotal.toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2,
    });

    return formattedItemTotal.replace(/[$,৳,€,£,₹]/g, '');
}

// Event listener for remove button
$('.remove').on('click', function () {
    var $removeButton = $(this);
    var cartItemId = $removeButton.data('cart-item-id');

    // var confirmRemove = confirm('Are you sure you want to remove this item from your cart?');
    // if (confirmRemove) {
        $.ajax({
            url: 'cart-item-remove',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                cart_item_id: cartItemId
            },
            success: function(response) {
                $removeButton.closest('tr').fadeOut("slow", function () {
                    $(this).remove();

                    // Recalculate cart total after item removal
                    calculateCartTotal();
                });

                // Header Cart
                $('.cartItemTotal').text(response.totalItem);

                // Side Cart
                $('.item-title').text(response.totalItem + ' Items');
                $('.items-image li:last').text('+' + response.totalItem - 3);
                $('.cart-total').text('Total: ' + response.totalAmount.toFixed(2));

                notify(response.message, 'success');


                if (response.totalItem == 0) {
                    $('.cartItemSection').css("display", "none");

                    const url = BASE_URL + "/";
                    var htmlToAppend = `
                        <div class="row g-sm-5 g-3">
                            <div class="col-xxl-12">
                                <div class="text-center">
                                    <p>There are no items in this cart</p>
                                    <a class="shopping-button" href="` + url + `">
                                        <button class="btn btn-light text-dark">
                                            Continue Shopping
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;

                    $('.itemNotFound').append(htmlToAppend);
                }
            },
            error: function(xhr, status, error) {
                notify('Opps! Something went wrong', 'danger');
            }
        });
    // }
});

// Function to update cart data with AJAX
function updateCartDataAndRedirect() {
    var cartData = [];

    $('.cartItems').each(function() {
        var $cartItem = $(this);

        var cartId = $cartItem.find('input[name="cart_id"]').val();
        var productId = $cartItem.find('input[name="product_id"]').val();
        var quantity = parseInt($cartItem.find('.qty-input').val());

        cartData.push({
            cartId: cartId,
            productId: productId,
            quantity: quantity
        });
    });

    $.ajax({
        url: '/cart-update',
        method: 'POST',
        data: {
            cartData: JSON.stringify(cartData),
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log('Cart data updated successfully');
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
$('#checkoutButton').on('click', function () {
    var isStockOut = $('.isStockOut').val();

    if (isStockOut == 1) {
        notify('Please remove stock out product from cart.', 'danger');

        return;
    }

    $(this).prop('disabled', true);

    updateCartDataAndRedirect();
});
