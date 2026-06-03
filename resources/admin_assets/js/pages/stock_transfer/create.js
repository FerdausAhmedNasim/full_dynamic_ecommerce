$(document).ready(function () {

    $("#branch_from_id").select2({
        placeholder: "Select From Branch",
        allowClear: true
    });

    $("#branch_to_id").select2({
        placeholder: "Select To Branch",
        allowClear: true
    });

    $("#product").select2({
        placeholder: "Select Stock...",
        allowClear: true
    });

    $('.form').on('submit', function (e) {
        if ($('#branch_from_id').val() == '' || $('#branch_from_id').val() == 'undefined') {
            notify('Branch From is empty, fill it!', 'warning');
            e.preventDefault();
        }

        if ($('#branch_to_id').val() == '' || $('#branch_from_id').val() == 'undefined') {
            notify('Branch To is empty, fill it!', 'warning');
            e.preventDefault();
        }

        if ($("#purchaseTable tr .product_id").length < 1) {
            notify('No Product added in List, fill it!', 'warning');
            e.preventDefault();
        }
    });

    $("#branch_from_id").change(function () {
        var branchId = $('#branch_from_id').val();
        var toBranch = $('#branch_to_id').val();

        if (branchId == toBranch) {
            notify('Both Branch can not be same!', 'error');
            $('#branch_from_id').val("").trigger('change');
        }

        $.ajax({
            url: "get-stock/" + branchId,
            type: 'GET',
            success: function (response) {

                $('#product').empty();

                $('.parent-row').empty();

                updateSubtotal();
                updateQuantity();

                $('#product').append('<option selected disabled>Select Stock</option>');
                $.each(response.stocks, function(index, val){
                    $('#product').append('<option value ="'+ val.id +'" data-name="'+ val.product.title +'" data-quantity="'+ val.quantity +'" data-price="'+ val.purchase_price +'">'+ val.product.title +' (qty - '+ val.quantity +')</option>');
                });
            }
        });

    });

    $("#branch_to_id").change(function () {
        var fromBranch = $('#branch_from_id').val();
        var toBranch = $('#branch_to_id').val();

        if (fromBranch == toBranch) {
            notify('Both Branch can not be same!', 'error');
            $('#branch_to_id').val("").trigger('change');
        }
    });

    $("#product").change(function () {
        var name = $("#product").find(':selected').data("name");
        var quantity = $(this).children(':selected').data('quantity');
        var price = $(this).children(':selected').data('price');

        var id = $(this).val();

        var row = '<tr class="parent-row">'
            +'<td>'
                +'<span class="product-name">'+ name +'</span>'
                +'<input type="hidden" class="form-control product_id" name="stock_id[]" value="'+ id +'">'
            +'</td>'
            +'<td>'
                +'<input class="form-control product-qty" type="number" name="quantity[]" min="1" value="1">'
            +'</td>'
            +'<td class="text-center">'
                +'<input type="number" class="form-control purchase_price" name="purchase_price[]" value="'+ price +'" readonly required>'
            +'</td>'
            +'<td class="sub-total-td text-center">'
                +'<span>'+ price +'</span>'
            +'</td>'
            +'<td class="text-center">'
                +'<button type="button" class="ibtnDel btn btn-md btn-danger">'
                    +'<i class="fa-solid fa-trash-can"></i>'
                +'</button>'
            +'</td>'
            +'<input type="hidden" class="form-control stock_quantity" name="stock_quantity[]" value="'+ quantity +'" required>'
            +'<input type="hidden" class="form-control sub_total" name="sub_total[]" value="'+ price +'" step="any" required>'
        +'</tr>'

        if (checkAlreadyExists(id)) {
            notify('Already added', 'error');
        } else {
            $('#purchaseTable > tbody').append(row);
        }

        updateSubtotal();
        updateQuantity();

    });+

    // Quantity Change
    $(document).on('change keyup', '.product-qty',function(){
        var parent = $(this).closest('.parent-row');
        var value = $(this).val();
        var stock_quantity = parent.find('.stock_quantity').val();

        if (parseInt(value) > parseInt(stock_quantity)) {
            parent.find('.product-qty').val(1).trigger('change');

            updateSubtotal();
            updateQuantity();

            notify('Quantity exceeds stock quantity!', 'error');
        } else {

            var purchase_price = parseFloat(parent.find('.purchase_price').val() ? parent.find('.purchase_price').val() : 0);
            var sub_total_amount = parseFloat(value * purchase_price);

            parent.find('.sub-total-td > span').html(sub_total_amount);
            parent.find('.sub_total').val(sub_total_amount);

            updateSubtotal();
            updateQuantity();
        }
    });

    function updateSubtotal() {

        var amount = 0;
        $("#purchaseTable tr .sub_total").each(function () {
            amount = parseFloat(amount) + parseFloat(this.value);
        });
        $("#total").html(amount);
    }

    function updateQuantity() {
        var qty = 0;
        $("#purchaseTable tr .product-qty").each(function () {
            qty = parseInt(qty) + parseInt(this.value);
        });
        $("#total-qty").html(qty);
    }

    function checkAlreadyExists(id) {
        var flag = false;
        $("#purchaseTable tr .product_id").each(function () {
            if(id == this.value) {
                flag=true;
            }
        });
        return flag;
    }

    $(document).on('click', '.ibtnDel', function(){
        var parent = $(this).closest('.parent-row');
        parent.remove();

        updateSubtotal();
        updateQuantity();
    });
});


