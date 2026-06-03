@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dropMe.css') }}">
@endpush


@push('scripts')
    <script src="{{ asset('assets/js/dropMe.js') }}"></script>

    <script>
        
        $(function () {
            // $('.dropMeInputImage').imageUploader();
            $('.dropMeInputImage').imageUploader({
                maxSize: 2 * 1024 * 1024,
                maxFiles: 5
            });
        });

    </script>
@endpush
