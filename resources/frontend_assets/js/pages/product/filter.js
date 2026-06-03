$(document).ready(function () {
    window.filter = function (filterBy = '') {

        var attributes = $(".filter-form").serializeArray();
      
            $.ajax({
                url: BASE_URL + "/products/filter",
                method: 'get',
                data: {
                    attributes: attributes,
                    filterBy:filterBy
                },
                dataType: 'json',
                success: function (response) {
                    if (response != '') {
                        $(".product-list-section").html(response);
                    }else{
                        $(".product-list-section").html(`<p>No Data Found</p>`);
                    }

                }
            });
      
    };

    window.ClearAll = function () {
        $(".filter-form")[0].reset();
        filter();
    }    
});