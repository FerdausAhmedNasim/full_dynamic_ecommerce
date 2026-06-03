$(document).ready( function () {
    $("#division_id").select2({
        placeholder: "Select One",
        allowClear: true
    });

    $("#district_id").select2({
        placeholder: "Select One",
        allowClear: true
    });

    $(document).on('change', '#division_id', function (e) {
        if ($(this).val()) {
            $.ajax({
                url: BASE_URL + "/area-settings/thana/district/get",
                method: 'get',
                data: {
                    division_id: $(this).val(),
                },
                dataType: 'json',
                success: function (response) {
                    if (response != '') {
                       $("#district_id").empty();
                       $("#district_id").html(response);
                    } else {
                        notify('No District Found !!','danger');
                    }
                }
            });
        }
    });
});