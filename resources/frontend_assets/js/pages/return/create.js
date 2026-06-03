$(document).ready(function () {

    $(document).on('click', '.plus', function(){
        var input  = $(this).closest('.quantity').find('.qty-input');
        var maxValue =  parseInt(input.attr('max'));
        var inputValue = parseInt(input.val());
        
        if (inputValue < maxValue && !input.is('[readonly]')) {
            input.val(inputValue + 1);
            input.trigger('change');
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

    $(document).on('keyup', '.qty-input', function(){
        var input  = $(this).closest('.quantity').find('.qty-input');
        var minValue = parseInt($(this).attr('min'));
        var maxValue = parseInt($(this).attr('max'));
        var inputValue = $(this).val();

        if (inputValue < minValue || inputValue > maxValue && !input.is('[readonly]')) {
            $(this).val(1);
            input.trigger('change');
        }
    });
    

    // Quantity Change
    $(document).on('change keyup', '.return-qty',function(){
        var parent = $(this).closest('.parent-row');
        var seller_order_id = parent.find('.seller_order_id').val();
        var value = $(this).val();

        var sale_price = parseFloat(parent.find('.sale_price').val() ? parent.find('.sale_price').val() : 0);
        var sub_total_amount = parseFloat(value * sale_price);

        parent.find('.subtotal > h5').html(formatPrice(sub_total_amount));
        parent.find('.sub_total').val(sub_total_amount);

        updateSubtotal(seller_order_id);
        updateQuantity(seller_order_id);
    });

    function updateSubtotal(seller_order_id) {
        var amount = 0;
        $(".order-table-"+seller_order_id+" tr .sub_total").each(function () {
            console.log(this.value);
            amount = parseFloat(amount) + parseFloat(this.value);
        });
        $("#total-amount-"+seller_order_id+"").html(formatPrice(amount));
        $(".total_amount").val(amount);
    }

    function updateQuantity(seller_order_id) {
        var qty = 0;
        $(".order-table-"+seller_order_id+" tr .return-qty").each(function () {
            qty = parseInt(qty) + parseInt(this.value);
        });
        $("#total-qty-"+seller_order_id+"").html(qty);
    }

    $('.is_return').change(function() {
        var parent = $(this).closest('.parent-row');
        var table = $(this).closest('.order-table');
        var input_qty  = parent.find('.return-qty');
        var is_return_demo  = parent.find('.is_return_demo');
        var is_seller_order_returnable  = $(this).closest('.accordion-item').find('.is_seller_order_returnable');
        
        if($(this).is(":checked")) {
            // console.log($(this).closest('.submit-btn'));
            input_qty.removeAttr('readonly');
            input_qty.attr('min',1);
            is_return_demo.attr('disabled','disabled');
            is_seller_order_returnable.val(1);
            table.find('.submit-btn').prop('disabled', false);
        }else{
            input_qty.val(0).trigger('change');
            input_qty.attr('min',0);
            input_qty.attr('readonly', 'readonly');
            is_return_demo.removeAttr('disabled');
            is_seller_order_returnable.val(0);
        }
     });
});

// $('.submit-btn').on('click', function (e) {
    window.submitForm = function (e, id = '') { 
        var is_valid = false;
        $(".order-table-"+id+" tr .is_return").each(function () {
            if($(this).is(":checked")){
                is_valid = true;
            }
        });
        
        if (!is_valid) {
            e.preventDefault();
            notify('No Product Choice, Choice One and Try Again!', 'danger');
        }
    };



