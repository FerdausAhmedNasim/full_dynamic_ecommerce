$(document).ready(function () {

    $("#supplier_id").select2({
        placeholder: "Select One",
        allowClear: true,
    });

    $("#branch_id").select2({
        placeholder: "Select One",
        allowClear: true
    });

    $("#product").select2({
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

    $("#product").change(function () {
        var name = $("#product").find(':selected').data("name");
        var unit = $("#product").find(':selected').data("unit");
        var id = $(this).val();

        var row = '<tr class="parent-row">'
        +'<td>'
        +' <span class="product-name">'+ name +'</span>'
            +'<input type="hidden" class="form-control product_id" name="product_id[]" value="'+ id +'">'
        +'</td>'
        +'<td class="text-center">'
        +' <span class="product-name">'+ unit +'</span>'
        +'</td>'
        +'<td>'
                +'<input class="form-control product-qty" type="number" name="quantity[]" min="1" value="1">'
        +'</td>'
        +'<td class="text-center">'
            +'<input type="number" class="form-control purchase_price" name="purchase_price[]" step="any" required>'
        +'</td>'
        +'<td class="text-center">'
           +'<input type="number" class="form-control sale_price" name="sale_price[]" min="1" step="any" required>'
       +'</td>'
        +'<td class="text-center">'
           +' <input type="number" class="form-control special_price" name="special_price[]" min="0" value="0" step="any">'
       +' </td>'
        +'<td class="text-center">'
            +'<input type="number" class="form-control stock_alert" name="stock_alert[]" value="1" min="1" required>'
        +'</td>'
        +'<td class="text-center">'
           +'<div class="input-group with-icon">'
                +'<input type="date" name="warranty_date[]" class="form-control warranty_date"'
                    +'placeholder="">'
                +''
           +' </div>'
        +'</td>'
        +'<td class="sub-total-td text-center">'
            +'<span>0.00</span>'
        +'</td>'
        +'<td class="text-center">'
            +'<button type="button" class="ibtnDel btn btn-md btn-danger">'
                +'<i class="fa-solid fa-trash-can"></i>'
            +'</button>'
        +'</td>'
        +'<input type="hidden" class="form-control sub_total" name="sub_total[]" value="0" step="any" required>'
    +'</tr>'

        if(checkAlreadyExists(id)){
            notify('already added', 'error');
        }else{
            $('#purchaseTable > tbody').append(row);
        }

        $('#product option:selected').remove();
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

    //Payment Change
    $(document).on('change keyup', '.payment',function(){
        var amount = calculate_payments();
        var due = updateDue();

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

    //Subtotal Change
    $(document).on('change', '.sub_total',function(){
        var parent = $(this).closest('.parent-row');
        var value = parseFloat($(this).val());
        var qty = parent.find('.product-qty').val();
        var sub_total_amount = parseFloat(value * qty);

        parent.find('.sub-total-td > span').html(formatPrice(sub_total_amount));
        parent.find('.sub_total').val(sub_total_amount);
    });

    $(document).on('click', '.amount_update', function(){
        var parent = $(this).closest('tr').find('.amount_div');
    
        if (parent.hasClass("d-none")) {
            parent.removeClass('d-none');
        }else{
            parent.addClass('d-none');
        }
        updateSubtotal();
    });

    $(document).on('change keyup', '#discount_amount,#delivery_cost,#packaging_cost',function(){

        var parent = $(this).closest('tr').find('.amount_th');
        var value = $(this).val() ? $(this).val() : 0;
        parent.html(formatPrice(value));
        updateTotal();
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
        updateQuantity();
        updateSubtotal();
    });
});

$(document).ready(function () {
    var i = 1;
    $("#add").click(function () {
        i++;
        $('#dynamic_field').append('<div class="row" id="row' + i + '">' +
            '<div class="col-xl-4 col-sm-4 col-12">' +
            '<div class="form-group">' +
            '<input type="text" name="name[]" id="name' + i + '" onkeyup="attachmentRequired(' + i + ')" class="form-control"' +
            'placeholder="File Name">' +
            '</div>' +
            '</div>' +

            '<div class="col-xl-6 col-sm-6 col-12">' +
            '<div class="form-group">' +
            '<div class="file-upload-section d-flex d-inline-flex w-100">' +
            '       <div class="input-group">' +
            '           <input type="text" class="form-control file-upload-info" disabled="" readonly' +
            '               placeholder="Size: 200x200 and max 500kB">' +
            '           <span>' +
            '               <button class="file-upload-browse btn btn-outline-secondary pb-3"' +
            '                   type="button"><i class="fas fa-upload"></i></button>' +
            '           </span>' +
            '       </div>' +
            '   <input name="attachment[]" type="file" id="attachment' + i + '" onchange="attachmentRequired(' + i + ')" class="form-control hidden-file" allowed="*">' +
            '       <div class="display-input-image display-input-image2 d-none">' +
            '           <img src="" alt="Preview Image" />' +
            '       </div>' +
            '   </div>' +
            '</div>' +
            '</div>' +
            '    <div class="col-md-2 d-flex align-items-center">' +
            '<div class="form-group">' +
            '        <button type="button" name="remove" id="' + i + '" class="btn btn-danger btn-sm icon-btn ms-3 mb-2 btn_remove"><i class="fas fa-close"></i></button>' +
            '    </div>' +
            '    </div>' +
            '</div>');
    });

    $(document).on('click', '.btn_remove', function () {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
    });

    window.attachmentRequired = function (id = '') {
        if (id == 1) {
            if ($('#name1').val() == '' && $('#attachment1').val() == '') {
                $('#name1').attr('required', false);
                $('#attachment1').attr('required', false);
            } else if ($('#name1').val() != '' && $('#attachment1').val() == '') {
                $('#attachment1').attr('required', 'required');
            } else if ($('#attachment1').val() != '' && $('#name1').val() == '') {
                $('#name1').attr('required', 'required');
            }
        } else {
            $('#name' + id + '').attr('required', 'required');
            $('#attachment' + id + '').attr('required', 'required');
        }
    }

});
