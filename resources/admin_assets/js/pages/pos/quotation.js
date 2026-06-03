$(document).ready(function () {

    $( ".showQuantityDiv" ).dblclick(function(event) {
        $(this).closest('.cart-item').find('.changeQtyDiv').removeClass('d-none');
    });

    $('.input-qty').on('keyup change', function(e) {
        var showQuantity = $(this).closest('.cart-item').find('.showQuantity');

        $(showQuantity).html($(this).val());
        
        if (e.keyCode === 13) {
            $(this).closest('.cart-item').find('.changeQtyDiv').addClass('d-none');
        }
    });

    //Add and remove payment card
    // $(document).on('click', '#add_payment_row', function () {
    //     var whole_extra_item_add = $('#qus_col').html();
    //     $('.payments_div').append(whole_extra_item_add);

    // });
    $(document).on('click', '.remove', function () {
        $(this).closest('.delete_extra_item').remove();
    });
    

});
