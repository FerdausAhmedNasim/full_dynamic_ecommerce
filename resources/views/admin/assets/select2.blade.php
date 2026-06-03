@push('styles')
    <link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">
@endpush
@push('scripts')
    <script src="{{asset('assets/js/select2.min.js')}}"></script>

    <script>

        $(document).ready(function () {
            $('.select_2_multiple').select2({
                placeholder: "Select One",
                allowClear: true
            });

            $('.select2').select2({
                placeholder: "Select One",
                allowClear: true
            });
        });
        
        // Start Select & Deselect All Option for MultiSelect
        $(document).on('click', '.select-all', function (e) {
            selectAllSelect2($(this).siblings('.selection').find('.select2-search__field'));
        });

        $(document).on("keyup", ".select2-search__field", function (e) {
            var eventObj = window.event ? event : e;
            if (eventObj.keyCode === 65 && eventObj.ctrlKey)
                selectAllSelect2($(this));
        });

        function selectAllSelect2(that) {

            var selectAll = true;
            var existUnselected = false;
            var item = $(that.parents("span[class*='select2-container']").siblings('select[multiple]'));

            item.find("option").each(function (k, v) {
                if (!$(v).prop('selected')) {
                    existUnselected = true;
                    return false;
                }
            });

            selectAll = existUnselected ? selectAll : !selectAll;

            item.find("option").prop('selected', selectAll);
            item.trigger('change');
        }
        // Start Select & Deselect All Option for MultiSelect
    </script>
@endpush
