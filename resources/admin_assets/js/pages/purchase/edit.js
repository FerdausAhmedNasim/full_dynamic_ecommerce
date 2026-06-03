$(document).ready(function () {

    $("#supplier_id").select2({
        placeholder: "Select One",
        allowClear: true,
    });

    $("#branch_id").select2({
        placeholder: "Select One",
        allowClear: true
    });

    $("#deleted_product").select2({
        placeholder: "Please type product code and select...",
        allowClear: true
    });

    $('.form').on('submit', function (e) {
        console.log($('#supplier_id').val());
        console.log($("#purchaseTable tr .product_id").length);

        if ($('#supplier_id').val() == '') {
            notify('Supplier is empty, fill it!', 'warning');
            e.preventDefault();
        }

        if ($('#branch_id').val() == '') {
            notify('Branch is empty, fill it!', 'warning');
            e.preventDefault();
        }

        if ($("#purchaseTable tr .product_id").length < 1) {
            notify('No Product added in List, fill it!', 'warning');
            e.preventDefault();
        }
    });

    // Quantity Change
    $(document).on('change keyup', '.product-qty',function(){
        var parent = $(this).closest('.parent-row');
        var value = $(this).val();

        var purchase_price = parseFloat(parent.find('.purchase_price').val() ? parent.find('.purchase_price').val() : 0);
        var sub_total_amount = parseFloat(value * purchase_price);

        parent.find('.sub-total-td > span').html(formatPrice(sub_total_amount));
        parent.find('.sub_total').val(sub_total_amount);

        updateSubtotal();
        updateQuantity();
    });

    //Purchase Change
    $(document).on('change keyup', '.purchase_price',function(){
        var parent = $(this).closest('.parent-row');
        var value = parseFloat($(this).val());
        var qty = parent.find('.product-qty').val();
        var sub_total_amount = parseFloat(value * qty);

        parent.find('.sub-total-td > span').html(formatPrice(sub_total_amount));
        parent.find('.sub_total').val(sub_total_amount);

        updateSubtotal();
    });

    //Subtotal Change
    $(document).on('change', '.sub_total',function(){
        var parent = $(this).closest('.parent-row');
        var value = parseFloat($(this).val());
        var qty = parent.find('.product-qty').val();
        var sub_total_amount = parseFloat(value * qty);

        parent.find('.sub-total-td > span').html(formatPrice(sub_total_amount));
        parent.find('.sub_total').val(sub_total_amount);
    });

    $(document).on('change keyup', '#discount_amount,#delivery_cost,#packaging_cost',function(){

        var parent = $(this).closest('tr').find('.amount_th');
        var value = $(this).val() ? $(this).val() : 0;
        parent.html(formatPrice(value));
        updateTotal();
    });

    // Add and remove payment card
    $(document).on('click', '#add_payment_row', function() {
        var whole_extra_item_add = $('#add_item').html();
        $('.payments_div').append(whole_extra_item_add);

    });

    $(document).on('click', '.remove', function() {
        $(this).closest('.delete_extra_item').remove();
        calculate_payments();
        updateDue();
    });

    //Payment Change
    $(document).on('change keyup', '.payment',function(){
        var amount = calculate_payments();
        var due = updateDue();
        console.log(due);

        if (due < 0) {
            notify('Pay Amount is Bigger then Due Amount', 'error');
            $(this).val(0);
            amount = calculate_payments();
        }
        updateDue();
    });

    function calculate_payments() {
        var amount = 0;
        $('input[name^="amount"]').each(function() {
            var pay = parseFloat($(this).val() > 0 ? $(this).val() : 0);
            amount = amount + pay;
        });

        $("#total_pay").html(formatPrice(amount));
        $("#total_pay_amount").val(amount);
        return amount;

    }

    $(document).on('click', '.amount_update', function(){
        var parent = $(this).closest('tr').find('.amount_div');
    
        if (parent.hasClass("d-none")) {
            parent.removeClass('d-none');
        }else{
            parent.addClass('d-none');
        }
        updateSubtotal();
    });

    function updateSubtotal() {
        var amount = 0;
        $("#purchaseTable tr .sub_total").each(function () {
            amount = parseFloat(amount) + parseFloat(this.value);
        });
        $("#subtotal_section").html(formatPrice(amount));
        $("#subtotal").val(amount);

        updateTotal();
    }

    function updateTotal() {

        var discount_amount = parseFloat($("#discount_amount").val() ? $("#discount_amount").val() : 0);
        var delivery_cost = parseFloat($("#delivery_cost").val() ? $("#delivery_cost").val() : 0);
        var packaging_cost = parseFloat($("#packaging_cost").val() ? $("#packaging_cost").val() : 0);
        var subtotal = parseFloat($("#subtotal").val() ? $("#subtotal").val() : 0);
        var total = subtotal - discount_amount+(delivery_cost+packaging_cost);
        
        $("#total").html(formatPrice(total));
        $("#total_amount").val(total);

        updateDue();
    }

    function updateDue() {

        var total_amount = parseFloat($("#total_amount").val() ? $("#total_amount").val() : 0);
        var total_pay_amount = parseFloat($("#total_pay_amount").val() ? $("#total_pay_amount").val() : 0);
        var total_due = total_amount - total_pay_amount;
        
        $("#total_due").html(formatPrice(total_due));
        $("#due_amount").val(total_due);

        return total_due;
    }

    function updateQuantity() {
        var qty = 0;
        $("#purchaseTable tr .product-qty").each(function () {
            qty = parseInt(qty) + parseInt(this.value);
        });
        $("#total-qty").html(qty);
    }

    $(document).on('click', '.ibtnDel', function(){
        var parent = $(this).closest('.parent-row');
        var product_id = parent.find('.product_id').val();
        var product_arr = $("#deleted_product").val();
        product_arr.push(product_id);
        $("#deleted_product").val(product_arr);
        $("#deleted_product").trigger('change');
        parent.remove();
        updateQuantity();
        updateSubtotal();
    });

});


