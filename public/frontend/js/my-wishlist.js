//  /**=====================
//      My Wishlist js
// ==========================**/

$(document).ready(function () {
    $.ajax({
        url: '/wishlist',
        type: "GET",
        success: function (response) {
            $('#wishlist').html(response.wishlist.length);
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
})

$('.btn-wishlist').on('click', function () {
    
    var productId = $(this).closest('.product-box-4').find('.product_id').val();
    var userId = $(this).closest('.product-box-4').find('.user_id').val();

    $.ajax({
        url: '/add-to-wishlist',
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            user_id: userId,
            product_id: productId
        },
        success: function (response) {
            if (response.wishlist) {
                $.notify({
                    icon: "fa fa-check",
                    title: "Success!",
                    message: "Item Successfully added in wishlist",
                }, {
                    element: "body",
                    position: null,
                    type: "info",
                    allow_dismiss: true,
                    newest_on_top: false,
                    showProgressbar: true,
                    placement: {
                        from: "top",
                        align: "right",
                    },
                    offset: 20,
                    spacing: 10,
                    z_index: 1031,
                    delay: 3000,
                    animate: {
                        enter: "animated fadeInDown",
                        exit: "animated fadeOutUp",
                    },
                    icon_type: "class",
                    template: '<div data-notify="container" class="col-xxl-3 col-lg-5 col-md-6 col-sm-7 col-12 alert alert-{0}" role="alert">' +
                        '<button type="button" aria-hidden="true" class="btn-close" data-notify="dismiss"></button>' +
                        '<span data-notify="icon"></span> ' +
                        '<span data-notify="title">{1}</span> ' +
                        '<span data-notify="message">{2}</span>' +
                        '<div class="progress" data-notify="progressbar">' +
                        '<div class="progress-bar progress-bar-info progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                        "</div>" +
                        '<a href="{3}" target="{4}" data-notify="url"></a>' +
                        "</div>",
                });
                $.ajax({
                    url: '/wishlist',
                    type: "GET",
                    success: function (response) {
                        $('#wishlist').html(response.wishlist.length);
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            }
        },
        error: function (xhr, status, error) {
            if (xhr.responseText) {
                location.pathname = "/login"
            }
        }
    });
});
