//  /**=====================
//      My Wishlist js
// ==========================**/

const getWishlistLength = () => {
    $(document).ready(function () {
        $.ajax({
            url: '/wishlist',
            type: "GET",
            success: function (response) {

                if (response.wishlist.length > 0) {
                    $('#wishlist').parent().css('display', 'block');
                    $('#wishlist').html(response.wishlist.length);
                }
                else{
                    $('#wishlist').parent().hide();
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    })
}

getWishlistLength();

$(document).on("click",".btn-wishlist",function() {
    var productId = $(this).closest('.product-box-4').find('.product_id').val() || $(this).closest('.right-box-contain').find('.product_id').val() || $(this).closest('.cartItems').find('.product_id').val();
    var userId = $(this).closest('.product-box-4').find('.user_id').val() || $(this).closest('.right-box-contain').find('.user_id').val() || $(this).closest('.cartItems').find('.user_id').val();
    var btn = $(this);
    
    $.ajax({
        url: '/add-to-wishlist',
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            user_id: userId,
            product_id: productId
        },
        success: function (response) {
            btn.addClass('text-danger delete-wishlist')

            if (response.wishlist) {
                showNotify("Added");
                getWishlistLength();
            }
        },
        error: function (xhr, status, error) {
            if (xhr.responseText) {
                location.pathname = "/login"
            }
        }
    });
});

$(document).on("click", ".delete-wishlist", function() {
    var btn = $(this);
    var productId = btn.closest('.product-box-4').find('.product_id').val() || btn.closest('.right-box-contain').find('.product_id').val() || btn.closest('.cartItems').find('.product_id').val();
    var userId = btn.closest('.product-box-4').find('.user_id').val() || btn.closest('.right-box-contain').find('.user_id').val() || btn.closest('.cartItems').find('.user_id').val();
    
    $.ajax({
        url: '/wishlist/delete',
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            user_id: userId,
            product_id: productId
        },
        success: function (response) {

            if (response.message) {
                btn.removeClass('text-danger delete-wishlist');
                btn.closest('.product-wishlist-box').hide();
                showNotify("Deleted");
                getWishlistLength();
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
})


// Show Notify
const showNotify = (param) => {
    $.notify({
        icon: "fa fa-check",
        title: "Success!",
        message: `Item Successfully ${param} in wishlist`,
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
}