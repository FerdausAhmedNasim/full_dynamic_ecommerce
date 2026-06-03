$(document).ready(function () {

    $('#addressEdit').on('click', function () {
        $('#emergency_contact_show').addClass('d-none');
        $('#emergency_contact_edit').removeClass('d-none');
    });

    $(".close, .btn-close").on('click', function () {
        $(".modal").modal('hide');
    })

    const updateUserStatusModal = "#updateUserStatusModal";

    window.clickUpdateStatus = function () {
        $(updateUserStatusModal).modal('show');
    }

    window.AcceptStock = function (id) {
        loading('show');

        axios.post(BASE_URL + '/users/employees/' + id + '/stock/accept')
            .then(response => {
                notify(response.data.message, 'success');
                setTimeout(function () {
                    location.reload();
                }, 2500);

            })
            .catch(error => {
                const response = error.response;
                if (response){
                    notify(response.data.message, 'error');
                }
            })
            .finally(() => {
                loading('hide');
            });
    }
});


(function ($) {
    'use strict';
    $(function () {
        /* Code for attribute data-custom-class for adding custom class to tooltip */
        if (typeof $.fn.popover.Constructor === 'undefined') {
            throw new Error('Bootstrap Popover must be included first!');
        }

        var Popover = $.fn.popover.Constructor;

        // add customClass option to Bootstrap Tooltip
        $.extend(Popover.Default, {
            customClass: ''
        });

        var _show = Popover.prototype.show;

        Popover.prototype.show = function () {

            // invoke parent method
            _show.apply(this, Array.prototype.slice.apply(arguments));

            if (this.config.customClass) {
                var tip = this.getTipElement();
                $(tip).addClass(this.config.customClass);
            }

        };

        $('[data-toggle="popover"]').popover()
    });
})(jQuery);