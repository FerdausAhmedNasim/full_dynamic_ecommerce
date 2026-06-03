var rowCount = $('.totalServiceFields').val();

$(document).ready(function () {
    $('#summernote').summernote({
        height: 400,
        placeholder: "Long Description",
    });
    $("#categories").select2({
        placeholder: "Select One",
        allowClear: true
    });
    $("#brand").select2({
        placeholder: "Select One",
        allowClear: true
    });
    $("#unit").select2({
        placeholder: "Select One",
        allowClear: true
    });
    $("#discount_type").select2({
        placeholder: "Select One",
        allowClear: true
    });
    $("#stock_visibility").select2({
        placeholder: "Select One",
        allowClear: true
    });
    $("#shipping_type").select2({
        placeholder: "Select One",
        allowClear: true
    });


    // $('#sku').prop('required', true);
    // $('#current_stock').prop('required', true);

    // Add Product Service fields
    $("#addServiceFields").click(function () {
        var imagePath = $('.noImgPath').val();

        if (rowCount >= 3) {
            notify('You can not add more than 3 rows', 'error');

            return;
        }

        $('#productService').append(
            '<div class="row parent_row">' +
            '   <div class="col-sm-4 form-group">' +
            '       <input type="text" class="form-control" name="product_service_title[]" maxlength="30" required value="" placeholder="Product Service Title">' +
            '   </div>' +
            '   <div class="col-sm-4 form-group">' +
            '       <input type="text" class="form-control" name="product_service_sub_title[]" maxlength="30" required value="" placeholder="Product Service Sub Title">' +
            '   </div>' +
            '   <div class="col-sm-2 form-group">' +
            '       <input type="text" class="form-control" name="product_service_order[]" min="1" max="3" required value="" placeholder="Product Service Order">' +
            '   </div>' +
            // '   <div class="col-sm-4 form-group file-upload-section">' +
            // '       <div class="row">' +
            // '           <div class="col-md-9">' +
            // '               <input name="product_service_icon[]" type="file" class="form-control d-none" allowed="webp,png,gif,jpeg,jpg">' +
            // '               <div class="input-group col-xs-12">' +
            // '                   <input type="text" class="form-control file-upload-info" disabled="" readonly placeholder="Size: 750X750 and max 512KB">' +
            // '                   <span class="input-group-append">' +
            // '                       <button class="file-upload-browse btn btn-outline-secondary" type="button"><i class="fas fa-upload"></i> Browse</button>' +
            // '                   </span>' +
            // '               </div>' +
            // '           </div>' +
            // '           <div class="col-md-3">' +
            // '               <div class="display-input-image">' +
            // '                   <img class="product-thumbnail" src="' + imagePath  + '" alt="Product Thumbnail" />' +
            // '               </div>' +
            // '           </div>' +
            // '       </div>' +
            // '   </div>' +
            '   <div class="col-md-2" style="margin-top:5px">' +
            '       <button type="button" name="remove" class="btn btn-danger btn-sm icon-btn serviceFieldRemove"><i class="fas fa-close"></i></button>' +
            '   </div>' +
            '</div>'
        );

        rowCount++;
    });
});

$(document).on('click', '.serviceFieldRemove', function () {
    rowCount--;

    $(this).closest(".parent_row").remove();
});

// $('#productTitle').keyup(function(e) {
//     const title = $(this).val();

//     $("#productSlug").val(convertToSlug(title));
// });

// $('#productTitle').change(function(e) {
//     const title = convertToSlug($(this).val());

//     $("#productSlug").val(title + '-' + getKey(10).toLowerCase());
// });

// Slug Generator
// function convertToSlug(Text) {
//     return Text.toLowerCase()
//         .replace(/ /g, "-")
//         .replace(/[^\w-]+/g, "");
// }

$(".barcode").click(function() {
    $("#barcode").val(getKey(16));
});

function getKey(length = 16) {
    var api_key = "";
    var string = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    for (var i = 0; i < length; i++)
        api_key += string.charAt(Math.floor(Math.random() * string.length));

    return api_key;
}

// Check Discount
$(".has_discount").click(function() {
    var isChecked = $(this).is(':checked');

    if (isChecked) {
        $("#discountTypeDiv").removeClass('d-none');
        $("#discountDiv").removeClass('d-none');
        $("#discountPeriodDiv").removeClass('d-none');

        $('.discountType').prop('required', true);
        $('.specialDiscount').prop('required', true);
        $('.discountPeriod').prop('required', true);
    } else {
        $("#discountTypeDiv").addClass('d-none');
        $("#discountDiv").addClass('d-none');
        $("#discountPeriodDiv").addClass('d-none');

        $('.discountType').prop('required', false);
        $('.specialDiscount').prop('required', false);
        $('.discountPeriod').prop('required', false);

        $(".discountType").val([]).trigger('change');
        $(".specialDiscount").val('');
        $(".discountPeriod").val('');
    }
});

// Check Variant
$(".has_variant").click(function() {
    $('#attributeSetsContainer').addClass('d-none')

    var isChecked = $(this).is(':checked');

    if (isChecked) {
        $("#withVariant").removeClass('d-none');
        $("#withoutVariant").addClass('d-none');

        $("#sku").val('');
        $("#sku").prop('disabled', true);
        $('#sku').prop('required', false);
        $("#current_stock").val('');
        $('#current_stock').prop('required', false);

        $('.colors-input').val([]);

        $('.colors-input').prop('required',true);
        $('.variant_price').prop('required',true);
        $('.variant_sku').prop('required',true);
        $('.variant_stock').prop('required',true);
    } else {
        $("#withVariant").addClass('d-none');
        $("#withoutVariant").removeClass('d-none');

        $("#sku").val('');
        $("#sku").prop('disabled', false);
        $('#sku').prop('required', true);
        $("#current_stock").val('');
        $('#current_stock').prop('required', true);

        // $(".attribute-sets").val([]).trigger('change');
        // $(".variant").val([]).trigger('change');

        $('#attributeSets').val([]);
        $('.attribute-values').html('');
        $('.variant-table').html('');

        $(".variant_name").val('');
        $(".variant_ids").val('');
        $(".variant_price").val('');
        $(".variant_sku").val('');
        $(".variant_stock").val('');

        $(".file-upload-info").val('');
        $('.variantImage').attr('src', );

        $('.colors-input').prop('required',false);
        $('.variant_price').prop('required',false);
        $('.variant_sku').prop('required',false);
        $('.variant_stock').prop('required',false);
    }
});

$(document).on('change', '#shipping_type', function (e) {
    if ($(this).val() == 'free_shipping') {
        $(".shippingFeeDiv").addClass('d-none');
        $("#shipping_fee").val('');
    } else {
        $(".shippingFeeDiv").removeClass('d-none');
    }
});

// Start Product Price & Stock Sections
// --------------------------------------------

// Attribute Sets

$(document).on('change', '.attribute-sets', function (e) {
    var isAnyColorChecked = $('#colorsContainer input[type="checkbox"]:checked').length > 0;

    if (isAnyColorChecked) {
        $('#attributeSetsContainer').removeClass('d-none')
        $('.attribute-values').removeClass('d-none')
        $('.variant-table').removeClass('d-none')

        $('.colors-input').prop('required',false);

        $('#sku').prop('disabled', false);
        $('#current_stock').prop('disabled', false);
    } else {
        $('#attributeSetsContainer').addClass('d-none')
        $('.attribute-values').addClass('d-none')
        $('.variant-table').addClass('d-none')

        // Clear attribute sets, attribute values, and variant table
        $('#attributeSets').val([]);
        $('.attribute-values').html('');
        $('.variant-table').html('');

        $('.colors-input').prop('required',true);
    }


    var form = $('#variant');
    var url = $(this).attr('data-url');

    $.ajax({
        type: "post",
        url: url,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: form.serialize(), // serializes the form's elements.
        dataType: 'html',
        success: function (response) {
            $('.attribute-values').html(response);
            $(".select2bs4").select2({
                placeholder: "Select One",
                allowClear: true
            });

            getVariant($('#variant'), form.attr('data-form'));
        },
        error: function (data) {
        }
    });
});

// Change Attribute Value or Change Variant
$(document).on('change', '.variant', function (e) {
    var form = $('#variant');
    var url = form.attr('data-form');

    getVariant(form, url);
});

// Get Variant Table
function getVariant(form, url) {
    $.ajax({
        type: "post",
        url: url,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: form.serialize(), // serializes the form's elements.
        dataType: 'html',
        success: function (data) {
            $('.variant-table').html(data);

            $('.variant_price').prop('required',true);
            $('.variant_sku').prop('required',true);
            $('.variant_stock').prop('required',true);
        },
        error: function (data) {
        }
    });
}
// End Product Price & Stock Sections
// --------------------------------------------
