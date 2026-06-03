$(document).ready(function () {
    $('#summernote').summernote({
        height: 400
    });
    
    $("#categories").select2({
        placeholder: "Select One",
        allowClear: true
    });   
    
    $("#brand").select2({
        placeholder: "Select One",
        allowClear: true
    });
});
    

