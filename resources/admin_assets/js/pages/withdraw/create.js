$(document).ready(function() {

    $("#branch_id").select2({
        placeholder: "Select One",
        allowClear: true
    });

    $('.form').on('submit', function (e) {

        if ($('#amount').val() == '') {
            notify('You Need To Select Valid Branch Which has Balance', 'warning');
            e.preventDefault();
        }

        if ($('#amount').val() < 1) {
            notify('Amount is = 0, Add Amount', 'warning');
            e.preventDefault();
        }
    });

    $("#branch_id").change(function () {
        var amount = parseFloat($("#branch_id").find(':selected').data("amount"));
        var withdraw_amount = parseFloat($("#branch_id").find(':selected').data("w_amount"));
        var available_amount = parseFloat(amount)- parseFloat(withdraw_amount);
    
        $("#amount_show").removeClass('d-none');
        $("#amount_show").html('Branch Available Balance is: '+available_amount);

        if(amount > 0) {
            $('#amount').attr('max', available_amount);
        }else{
            $('#amount').attr('max', available_amount);
        }
    });

});
