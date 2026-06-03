$(document).ready(function () {

    $(document).on('change', '#updateDivisionId', function (e) {
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
                        $("#updateDistrictId").empty();
                        $("#updateDistrictId").html(response);
                    } else {
                        notify('No District Found !!', 'danger');
                    }
                }
            });
        }
    });

    $(document).on('change', '#updateDistrictId', function (e) {
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
                        $("#updateThanaId").empty();
                        $("#updateThanaId").html(response);
                    } else {
                        notify('No Thana Found !!', 'danger');
                    }
                }
            });
        }
    });

    $(document).on('change', '#updateThanaId', function (e) {
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
                        $("#updateAreaId").empty();
                        $("#updateAreaId").html(response);
                    } else {
                        notify('No Area Found !!', 'danger');
                    }
                }
            });
        }
    });
});