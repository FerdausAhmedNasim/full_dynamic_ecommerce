$(document).ready(function () {

    $(".select-2").select2({
        placeholder: "Select One",
        allowClear: true
    });


    $('#break_type').on('change', function() {
        var break_type = $(this).children(':selected').data('params');

        if (break_type == 'leaving') {
            $('#expected_back_time').removeAttr('required');
            $('#break_time_div').addClass("d-none");
        } else {
            $('#expected_back_time').attr('required', 'required');
            $('#break_time_div').removeClass("d-none");
        }
    });

    $("#signInBtn").on('click', function(){
        $("#signInBtn").addClass('btn2-success-active');
        $("#signOutBtn").removeClass('btn2-danger-active');
        $("#visitorSignInForm").removeClass('d-none');
        $("#visitorSignOutForm").addClass('d-none');
    });

    $("#signOutBtn").on('click', function(){
        $("#signInBtn").removeClass('btn2-success-active');
        $("#signOutBtn").addClass('btn2-danger-active');

        $("#visitorSignInForm").addClass('d-none');
        $("#visitorSignOutForm").removeClass('d-none');
    });

    $('#kaimaihiList').on('change', function(){
        let employeeId = $(this).val();
        loading('show');
        axios.get(BASE_URL + '/attendance/' + employeeId)
        .then(response => {
          let data = response.data.data;

          if (data == null) {
                $("#can_sign_in").val('yes');
                $(".employeeIn").removeClass('d-none');
                $(".employeeIn").addClass('block');
                $(".employeeOut").addClass('d-none');

                $(".outDiv").addClass('d-none');
                $(".inDiv").removeClass('d-none');
                $(".inDiv").addClass('block');

                $('#break_type').removeAttr('required');

          } else if (data && data.out_time == null) {
                $("#can_sign_in").val('no');
                $(".employeeOut").removeClass('d-none');
                $(".employeeOut").addClass('block');
                $(".employeeIn").addClass('d-none');
                $(".inDiv").addClass('d-none');
                $(".outDiv").removeClass('d-none');
                $(".outDiv").addClass('block');

                $('#break_type').attr('required', 'required');
          } else {
                $("#can_sign_in").val('yes');
                $(".employeeIn").removeClass('d-none');
                $(".employeeIn").addClass('block');
                $(".employeeOut").addClass('d-none');

                $(".outDiv").addClass('d-none');
                $(".inDiv").removeClass('d-none');
                $(".inDiv").addClass('block');

                $('#break_type').removeAttr('required');
          }
        })
        .catch(error => {
            if (error.response) {
                notify(error.response.data.message, 'error');
            }
        })
        .finally(() => {
            loading('hide');
        });
    });
});


