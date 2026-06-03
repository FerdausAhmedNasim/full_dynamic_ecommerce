
$(document).ready(function () {

    $("#deleted_product").select2({
        placeholder: "Please type product code and select...",
        allowClear: true
    });

    $('.form').on('submit', function (e) {

        if ($("#purchaseTable tr .product_id").length < 1) {
            notify('No Product added in List, fill it!', 'warning');
            e.preventDefault();
        }
    });

    // Quantity Change
    $(document).on('change', '.product-qty',function(){
        var parent = $(this).closest('.parent-row');
        var value = $(this).val();

        var purchase_price = parseFloat(parent.find('.sale_price').val() ? parent.find('.sale_price').val() : 0);
        var sub_total_amount = parseFloat(value * purchase_price);

        parent.find('.sub-total-td > span').html(formatPrice(sub_total_amount));
        parent.find('.sub_total').val(sub_total_amount);

        updateSubtotal();
        updateQuantity();
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
        updateSubtotal();
    });


    function updateSubtotal() {

        var discount_amount = parseFloat($("#discount_amount").val() ? $("#discount_amount").val() : 0);
        var delivery_cost = parseFloat($("#delivery_cost").val() ? $("#delivery_cost").val() : 0);
        var packaging_cost = parseFloat($("#packaging_cost").val() ? $("#packaging_cost").val() : 0);
        var amount = 0;
        $("#purchaseTable tr .sub_total").each(function () {
            amount = parseFloat(amount) + parseFloat(this.value);
        });
        $("#total").html(formatPrice(amount - discount_amount+(delivery_cost+packaging_cost)));
        $("#total_amount").val(amount - discount_amount+(delivery_cost+packaging_cost));
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
        var detail_id = parent.find('.detail_id').val();
        
        $.ajax({
            url: 'order-product-delete',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                detail_id: detail_id,
            },
            success: function(response) {
                notify('Order Product Deleted Successfully', 'success');
                location.reload();
            },
            error: function(xhr, status, error) {
                notify('Opps! Something went wrong', 'danger');
                // location.reload();
            }
        });
    });
});


