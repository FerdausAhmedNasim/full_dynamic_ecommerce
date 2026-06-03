$(document).ready(function () {
    $("#is_for_emp").prop('checked', false);

    $('.user-type-radio').change(function() {
        if ($(this).val() == '1') {
            $(".general").removeClass('d-none');
            $(".tournament").addClass('d-none');
        } else if ($(this).val() == '2') {
            $(".general").addClass('d-none');
            $(".tournament").removeClass('d-none');
        }
    });

    $("#tournament").select2({
        placeholder: "Select One",
        allowClear: true,
    });

    $("#user_status").select2({
        placeholder: "Select One",
        allowClear: true,
    });

    $("#user_type").select2({
        placeholder: "Select One",
        allowClear: true,
    });

    $('#exampleTextarea1').summernote({
        height: 350,
        inheritPlaceholder: true,
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: true // set focus to editable area after initializing
    });
});
