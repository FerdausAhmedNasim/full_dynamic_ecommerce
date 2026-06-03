{{--
    https://www.jqueryscript.net/time-clock/Date-Range-Picker-For-Twitter-Bootstrap.html#google_vignette
--}}

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/plugin/datetimepicker/daterangepicker.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/plugin/datetimepicker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugin/datetimepicker/daterangepicker.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            // single date picker
            $('.datepicker').daterangepicker({
                // autoApply: true,
                showDropdowns: true,
                singleDatePicker: true,
                locale: {
                    format: inputDateFormat
                }
            });

            // single date picker with minimum date
            $('.datepicker-min-today').daterangepicker({
                // autoApply: true,
                showDropdowns: true,
                singleDatePicker: true,
                minDate: new Date(),
                locale: {
                    format: inputDateFormat
                }
            });

            // single date picker with maximum date
            $('.datepicker-max-today').daterangepicker({
                // autoApply: true,
                showDropdowns: true,
                singleDatePicker: true,
                maxDate: new Date(),
                locale: {
                    format: inputDateFormat
                }
            });


            // only time picker with 12 hour format
            $('.timepicker').daterangepicker({
                // autoApply: true,
                timePicker: true,
                timePickerIncrement: 1,
                timePicker24Hour: hourFormat,

                showDropdowns: true,
                singleDatePicker: true,
                locale: {
                    format: inputTimeFormat
                }
            }).on('show.daterangepicker', function (ev, picker) {
                picker.container.find(".calendar-table").hide();
            });

            // date time picker with 12 hour format
            $('.datetimepicker').daterangepicker({
                // autoApply: true,
                timePicker: true,
                timePickerIncrement: 1,
                timePicker24Hour: hourFormat,

                showDropdowns: true,
                singleDatePicker: true,
                locale: {
                    format: inputDateTimeFormat
                }
            });

            // date time picker with minimum date today
            $('.datetimepicker-min-today').daterangepicker({
                // autoApply: true,
                timePicker: true,
                timePickerIncrement: 1,
                timePicker24Hour: hourFormat,

                showDropdowns: true,
                singleDatePicker: true,
                minDate: moment(new Date()).format(inputDateFormat),
                locale: {
                    format: inputDateTimeFormat
                }
            });
            // date time picker with minimum date & time now
            $('.datetimepicker-min-now').daterangepicker({
                // autoApply: true,
                timePicker: true,
                timePickerIncrement: 1,
                timePicker24Hour: hourFormat,

                showDropdowns: true,
                singleDatePicker: true,
                minDate: new Date(),
                locale: {
                    format: inputDateTimeFormat
                }
            });

            // date time picker with maximum date today
            $('.datetimepicker-max-today').daterangepicker({
                // autoApply: true,
                timePicker: true,
                timePickerIncrement: 1,
                timePicker24Hour: hourFormat,

                showDropdowns: true,
                singleDatePicker: true,
                maxDate: moment(new Date()).format(inputDateFormat),
                locale: {
                    format: inputDateTimeFormat
                }
            });

            // date time picker with maximum date & time now
            $('.datetimepicker-max-now').daterangepicker({
                // autoApply: true,
                timePicker: true,
                timePickerIncrement: 1,
                timePicker24Hour: hourFormat,

                showDropdowns: true,
                singleDatePicker: true,
                maxDate: new Date(),
                locale: {
                    format: inputDateTimeFormat
                }
            });


            // date range picker only date format
            var options = {};
            options.opens = 'right',
            options.locale = {
                format: inputDateFormat,
                separator: ' - ',
                applyLabel: 'Apply',
                cancelLabel: 'Cancel',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            }

            $('#daterangepicker').daterangepicker(options, function(start, end, label) {});

            // date range picker only date format for Report
            $('#daterangepicker-for-report').daterangepicker(options, function(start, end, label) {
                $('#fromDate').val(start.format('YYYY-MM-DD'));
                $('#toDate').val(end.format('YYYY-MM-DD'));
            });

            // Date range value clear
            $('#daterangepicker-for-report').val("");
            $('#daterangepicker-for-report').on('cancel.daterangepicker', function(ev, picker) {
                $('#daterangepicker-for-report').val("");
            });

            // date range picker date & time format
            var options2 = {};
            options2.opens = 'right',
            options2.timePicker = true,
            options2.minDate = new Date(),
            options2.locale = {
                format: inputDateTimeFormat,
                separator: ' - ',
                applyLabel: 'Apply',
                cancelLabel: 'Cancel',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            }

            $('#datetimerangepicker').daterangepicker(options2, function(start, end, label) {});

            // date-time range picker for special discount period
            $('#datetimerangepicker').daterangepicker(options2, function(start, end, label) {
                $('#fromDate').val(start.format('YYYY-MM-DD HH:mm:ss'));
                $('#toDate').val(end.format('YYYY-MM-DD HH:mm:ss'));
            });

            // Date range value clear
            // $('#datetimerangepicker').val("");
            $('#datetimerangepicker').on('cancel.datetimerangepicker', function(ev, picker) {
                $('#datetimerangepicker').val("");
            });

        });
    </script>
@endpush
