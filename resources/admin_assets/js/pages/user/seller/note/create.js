$(document).ready(function () {
    $('#summernote').summernote({
        height: 350,
        inheritPlaceholder: true,
        minHeight: null,
        maxHeight: null,
        focus: true
    });

    $('.form').on('submit', function(e) {
        if($('#summernote').summernote('isEmpty')) {
            notify('Note description is empty, fill it!', 'warning');
          e.preventDefault();
        }
    });
});


