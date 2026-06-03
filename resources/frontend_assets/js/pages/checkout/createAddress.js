$(document).ready(function () {

    $(document).on('change', '#division_id', function (e) {
        if ($(this).val()) {
            $.ajax({
                url: BASE_URL + "/addresses/district/get",
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
                        notify('No District Found !!', 'danger');
                    }
                }
            });
        }
    });

    $(document).on('change', '#district_id', function (e) {
        if ($(this).val()) {
            $.ajax({
                url: BASE_URL + "/addresses/thana/get",
                method: 'get',
                data: {
                    district_id: $(this).val(),
                },
                dataType: 'json',
                success: function (response) {
                    if (response != '') {
                        $("#thana_id").empty();
                        $("#thana_id").html(response);
                    } else {
                        notify('No Thana Found !!', 'danger');
                    }
                }
            });
        }
    });

    $(document).on('change', '#thana_id', function (e) {
        if ($(this).val()) {
            $.ajax({
                url: BASE_URL + "/addresses/area/get",
                method: 'get',
                data: {
                    thana_id: $(this).val(),
                },
                dataType: 'json',
                success: function (response) {
                    if (response != '') {
                        $("#area_id").empty();
                        $("#area_id").html(response);
                    } else {
                        notify('No Area Found !!', 'danger');
                    }
                }
            });
        }
    });
});