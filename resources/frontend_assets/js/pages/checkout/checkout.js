$(document).ready(function() {
    $('.btn-apply').click(function() {
        var button = $(this);

        var couponCode = button.prev().val(); 
        var sellerId = button.closest('.coupon-cart').find('.seller_id').val();
        var subTotal = button.closest('.coupon-cart').find('.sub_total').val();
        
        if (!couponCode) {
            $('.coupon-cart .coupon-message').remove();
            button.closest('.coupon-cart').append('<span class="coupon-message text-danger">Coupon code is required.</span>');

            return;
        }

        $('.coupon-cart .coupon-message').remove();
        
        $.ajax({
            type: 'POST',
            url: '/apply-coupon', 
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                sellerId: sellerId,
                coupon_code: couponCode,
                subTotal: subTotal,
            },
            success: function(response) {
                if (response.success) {
                    var couponDiscountElement = button.closest('.sellerItemFooter').find('.coupon-discount');
                    couponDiscountElement.text('Coupon Discount: ' + getFormattedAmount(response.discount_amount));

                    button.closest('.sellerItemFooter').find('.seller_coupon_discount').val(response.discount_amount);

                    notify('Coupon Applied Successfully', 'success');

                    updateOrderSummary(); 
                } else {
                    button.prev().val('');
                    button.closest('.sellerItemFooter').find('.coupon-discount').text('');
                    button.closest('.coupon-cart').append('<span class="coupon-message text-danger">' + response.message + '</span>');

                    button.closest('.sellerItemFooter').find('.seller_coupon_discount').val(0);

                    notify('Opps! Something went wrong', 'danger');

                    updateOrderSummary(); 
                }
            },
            error: function(xhr, status, error) {
                button.prev().val('');
                button.closest('.sellerItemFooter').find('.coupon-discount').text('');
                $('.coupon-message').text('An error occurred while applying the coupon: ' + error);

                button.closest('.sellerItemFooter').find('.seller_coupon_discount').val(0);

                // notify('Opps! Something went wrong', 'danger');

                updateOrderSummary(); 
            }
        });
        
    });
});

updateOrderSummary();

// Function to update the order summary data
function updateOrderSummary() {
    var subtotal = 0;
    var coupon = 0;

    $('.checked-item').each(function() {
        var itemTotal = parseFloat($(this).find('.sub_total').val());
        var sellerCouponDiscount = parseFloat($(this).find('.seller_coupon_discount').val()) ;

        subtotal += itemTotal;

        coupon += sellerCouponDiscount;
    });

    var shippingCost = parseFloat($('.shipping-price').text().replace(/[^\d.-]/g, ''));
    var penaltyAmount = parseFloat($('.penalty-charge').text().replace(/[^\d.-]/g, ''));

    if (!penaltyAmount) {
        penaltyAmount = 0;
    }

    var total = subtotal + shippingCost + penaltyAmount - coupon;

    $('.summery-total .subtotal-price').text(`৳${subtotal}`); 
    $('.summery-total .shipping-price').text(`৳${shippingCost}`); 
    $('.summery-total .coupon-price').text(`৳${coupon}`); 
    $('.summery-total .total-price').text(`৳${total}`); 
}

function getFormattedAmount(amount) {
    var formattedAmount = amount.toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2,
    });

    return formattedAmount.replace(/[$,৳,€,£,₹]/g, '');
}

// Event listener for remove button
$('.remove').on('click', function () {
    var $removeButton = $(this);
    var cartItemId = $removeButton.data('cart-item-id');

    // var confirmRemove = confirm('Are you sure you want to remove this item from your cart?');
    // if (confirmRemove) {  
        $.ajax({
            url: '/cart-item-remove',
            type: 'POST',
            data: { 
                _token: $('meta[name="csrf-token"]').attr('content'),
                cart_item_id: cartItemId 
            },
            success: function(response) {
                notify(response.message, 'success');

                location.reload();
            },
            error: function(xhr, status, error) {
                // notify('Opps! Something went wrong', 'danger');
            }
        });
    // }
});

// When the "Place Order" button is clicked
$('.btn-place-order').on('click', function(e) {
    e.preventDefault();
    var subtotalPrice = parseFloat($('.subtotal-price').text().replace(/[^\d.-]/g, ''));
    var quantity = parseFloat($('.totalQuantity').val());
    var name = $('input[name="name"]').val();
    var phone = $('input[name="phone"]').val();
    var address = $('input[name="address"]').val();
    var shippingArea = $('input[name="shippingArea"]:checked').val();
    var shippingCost = $('input[name="shippingArea"]:checked').data('cost');

    if (name === '' || phone === '' || address === '') {
        notify('Please provide your name, phone number, and shipping address.', 'danger');
        return;
    }

    // var paymentMethod = $('input[name="payment_method"]:checked').val();
    // if (!paymentMethod) {
    //     notify('Please select a payment method.', 'danger');

    //     return;
    // }

    var sellerCartData = [];
    var orderProducts = [];

    $('.checkout-items').each(function(index, element) {
        var sellerId = $(element).find('input[name="seller_id"]').val();
        var couponCode = $(element).find('input[name="coupon_code"]').val();
        var sellerCouponDiscount = parseFloat($(element).find('input[name="seller_coupon_discount"]').val());

        var sellerData = {
            seller_id: sellerId,
            coupon_code: couponCode,
            seller_coupon_discount: sellerCouponDiscount,
            sellerSubTotal: subtotalPrice,
            sellerQuantity: quantity,
            // sellerEzzicoDiscount: sellerEzzicoDiscount,
        };

        sellerCartData.push(sellerData);
    });

    $('.cart-items').each(function(index, element) {
        var product_qty = parseInt($(element).find('.qty-input').val());
        var cart_id = parseInt($(element).find('.cart_id').val());

        orderProducts.push([product_qty, cart_id]);
    })

    // var shippingPrice = parseFloat($('.shipping-price').text().replace(/[^\d.-]/g, ''));
    var couponPrice = parseFloat($('.coupon-price').text().replace(/[^\d.-]/g, ''));
    var orderTotalPrice = parseFloat($('.orderTotalPrice').text().replace(/[^\d.-]/g, ''));
    var penaltyAmount = parseFloat($('.penalty-charge').text().replace(/[^\d.-]/g, ''));
    
    if (!penaltyAmount) {
        penaltyAmount = 0;
    }

    if (!penaltyAmount) {
        penaltyAmount = 0;
    }

    // let advanceShippingCost = $('input[name="advance_shipping_cost"]').val();

    var obj = {};
    obj.sellerCartData= sellerCartData,
    // obj.shippingAddress= shippingAddress,
    obj.orderPersonName = name,
    obj.orderPersonPhone = phone,
    obj.orderPersonAddress = address,
    obj.shippingArea = shippingArea,
    obj.subtotalPrice= subtotalPrice,
    obj.shippingPrice= shippingCost,
    obj.couponPrice= couponPrice,
    // obj.paymentMethod= paymentMethod, 
    obj.orderTotalPrice= orderTotalPrice,
    obj.totalQuantity= quantity,
    obj.penalty_amount= penaltyAmount;
    obj.orderProducts = orderProducts

    // if (advanceShippingCost != 1 && paymentMethod == 'cashOnDelivery') {
    $.ajax({
        type: 'POST',
        url: '/place-order', 
        data: { 
            _token: $('meta[name="csrf-token"]').attr('content'),
            cart_json: JSON.stringify(obj),
        },
        success: function(response) {
            if (response.success) {
                notify(response.message, 'success');

                window.location.href = '/order-confirmation';
            } else {
                notify(response.message, 'danger');
            }
        },
        error: function(xhr, status, error) {
            notify('Opps! Something went wrong', 'danger');
        }
    });
    // } else {
    //     $('#sslczPayBtn').prop('postdata', obj);
    // }
});

$(document).ready(function() {
    function updateButton() {
        let addressSelected = $('.getAddress:checked').length > 0;
        let paymentMethodSelected = $('.payment_method:checked').length > 0;
        let selectedPaymentMethod = $('input[name="payment_method"]:checked').val();
        
        if (addressSelected && paymentMethodSelected) {
            let advanceShippingCost = $('input[name="advance_shipping_cost"]').val();

            if (advanceShippingCost != 1 && selectedPaymentMethod == 'cashOnDelivery') {
                $('.btn1').removeClass('d-none');
                // $('.btn2').addClass('d-none');
            } else {
                $('.btn1').addClass('d-none');
                // $('.btn2').removeClass('d-none');
            }            
        } else {
            $('.btn1').removeClass('d-none');
            // $('.btn2').addClass('d-none');
        }
    }

    $('.getAddress').change(function() {
        if ($(this).is(':checked')) {
            let address_id = $(this).attr('id').replace('defaultShipping', '')
            let inputFiled = $(this);
            $.ajax({
                url: '/defaultShipping',
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: address_id
                },
                success: function(response) {
                    $('.summery-total .shipping-price').text(getFormattedAmount(response.totalShippingCost));
                    
                    $('.address-box').removeClass('active');
                    inputFiled.closest('.address-box').addClass('active');
                    $(".address-form-check").find(".deliver-card-active").addClass("d-none");
                    
                    inputFiled.parent().append(
                        `<span class="deliver-card-active">
                            <span class="active-icon"><i class="fa-solid fa-check"></i></i></span>
                        </span>`
                    );

                    updateOrderSummary();
                    updateButton(); 

                    notify('Successfully Update Default Address', 'success');
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    // notify('Something is wrong !!', 'danger');
                }
            });
        }
    });

    $('.payment_method').change(function() {
        $('#paymentMethod').val($(this).val());

        if ($(this).is(':checked')) {
            $('.active1').addClass('d-none');
            $('.payment-method-box').removeClass('active')
            $(this).closest('.payment-method-box').addClass('active')

            $(this).parent().append(
                `<span class="deliver-card-active active1">
                    <span class="active-icon"><i class="fa-solid fa-check"></i></i></span>
                </span>`
            );

            updateButton(); 
        }
    })

    updateButton(); 

    function calculateCartTotal() {
        var subtotal = 0;
        var totalDiscountPrice = 0;
        var totalQuantity = 0;
    
        $('.cart-items').each(function() {
            var qty = parseInt($(this).find('.qty-input').val());
            var itemTotal = parseFloat($(this).find('.productPrice').text().replace(/[^\d.-]/g, '')) * qty;
            var discountPrice = parseFloat($(this).find('#discountPrice').val()) * qty;

            totalDiscountPrice += discountPrice;
            subtotal += itemTotal;
            totalQuantity += qty;
        });

        var shippingCost = parseFloat($('input[name="shippingArea"]:checked').data('cost'));
        var total = subtotal + shippingCost;
    
        // Update the subtotal, coupon discount, shipping, and total on the page
        $('.subtotal-price').text('৳' + subtotal.toFixed(2));
        $('.shipping-price').text('৳' + shippingCost.toFixed(2));
        $('.orderTotalPrice').text('৳' + total.toFixed(2));
        $('.savePrice').text('৳' + totalDiscountPrice.toFixed(2));
        $('.totalQuantity').val(totalQuantity);
    
        if (total > 0) {
            $("#checkoutButton").removeAttr('disabled', 'disabled');
        } else {
            $("#checkoutButton").attr('disabled', true)
        }
    }

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

        // var price = $(this).closest('tr').find('.unitPrice').val();

        // var itemTotal = calculateItemTotal(price, quantity);

        // $(this).closest('tr').find('.item-total').text(itemTotal);

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

        // var price = $(this).closest('tr').find('.unitPrice').val();
        // var quantity = $(this).siblings(".qty-input").val();

        // var itemTotal = calculateItemTotal(price, quantity);

        // $(this).closest('tr').find('.item-total').text(`৳${itemTotal}`);

        // Recalculate cart total after quantity change
        calculateCartTotal();
    });

    // Event listener for quantity increase button
    $('.qty-right-plus').click(function () {
        var price = $(this).closest('.quantity-price').parent().find('.unitPrice').val();
        var current_stock = $(this).closest('.quantity-price').parent().find('.current_stock').val();
        var $qty = $(this).siblings(".qty-input");
        var currentVal = parseInt($qty.val());

        if (currentVal < current_stock) {
            $(this).prev().val(+$(this).prev().val() + 1);
        }

        // var quantity = parseInt($(this).prev().val());

        // var itemTotal = calculateItemTotal(price, quantity);

        // $(this).closest('tr').find('.item-total').text(`৳${itemTotal}`);

        // Recalculate cart total after quantity change
        calculateCartTotal();
    });

    $('input[name="shippingArea"]').on('change', function () {
        calculateCartTotal();
    });
});