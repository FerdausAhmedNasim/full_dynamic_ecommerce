window.notify = function (message, type = 'success', callback = null) {
    var icon = "fa fa-check";
    if(type != 'success'){
        var icon = "fa fa-triangle-exclamation";
    }
    $.notify({
        icon: icon,
        title: "",
        message: message,
    }, {
        element: "body",
        position: null,
        type: type,
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
        delay: 5000,
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


window.validationForm = function (selector, errors)
 {

     $.each(errors, function(fieldName, fieldErrors)
     {
         $.each(fieldErrors, function(errorType, errorValue) {

             var fieldSelector = selector + " [name='"+fieldName+"']";

             if($(fieldSelector).parents(".form-group").hasClass("error")) {
                 $(fieldSelector).parents(".form-group").find(".error-message").remove();
                 $(fieldSelector).parents(".form-group").removeClass("error");
             }

             $("<p class='error-message'>"+errorValue+"</p>")
                 .insertAfter(fieldSelector)
                 .parents(".form-group").addClass('error');

             $(fieldSelector).on("keyup", function(event) {
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if(keycode == '13')
                    return;
                $(fieldSelector).parents(".form-group").find(".error-message").remove();
                $(fieldSelector).parents(".form-group").removeClass("error");
             });
         });
     });
 }

window.clearValidation = function (selector)
 {
    const form_data = $(selector).serializeArray();
    $.each(form_data, function(id, field)
    {
        var fieldSelector = selector + " [name='"+field.name+"']";
        if($(fieldSelector).parents(".form-group").hasClass("error")) {
            $(fieldSelector).parents(".form-group").find(".error-message").remove();
            $(fieldSelector).parents(".form-group").removeClass("error");
        }
    });
 }


 window.formatMoney = function(price,decPlaces, thouSeparator, decSeparator) {
    var n = price,
        decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
        decSeparator = decSeparator == undefined ? "." : decSeparator,
        thouSeparator = thouSeparator == undefined ? "," : thouSeparator,
        sign = n < 0 ? "-" : "",
        i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return sign + (j ? i.substr(0, j) + thouSeparator : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator) + (decPlaces ? decSeparator + Math.abs(n - i).toFixed(decPlaces).slice(2) : "");
};

//  Format Price
 window.formatPrice = function (price)
 {
    let currency_symbol = $("meta[name='currency_symbol']").attr("content");
    // Format the price with 2 decimal places and a comma as the thousands separator
    var formattedPrice = formatMoney(price,2, ',', '.');

    // console.log(currency_symbol);
    // Add a dollar sign to the beginning of the formatted price
    formattedPrice = (currency_symbol ?? '$') + formattedPrice;

    return formattedPrice;
 }
