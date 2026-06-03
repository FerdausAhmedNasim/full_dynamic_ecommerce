 /**=====================
     Quantity 2 js
==========================**/
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
    
});