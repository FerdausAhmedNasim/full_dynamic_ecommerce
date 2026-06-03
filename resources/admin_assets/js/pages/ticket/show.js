$('#fileButton').click(function () {
    $('#fileOpen').click();
    $('#fileOpen').change(function () {
        var fileName = $(this).val().split('\\')[$(this).val().split('\\').length - 1];
        var sFileExtension = $(this).val().split('.')[$(this).val().split('.').length - 1].toLowerCase();

        if (!(sFileExtension === "pdf" || sFileExtension === "doc" || sFileExtension === "docx" || sFileExtension === "png" ||
                sFileExtension === "gif" ||
                sFileExtension === "jpg" ||
                sFileExtension === "jpeg")
            ){

            var txt = "Please make sure your file is in  (png,gif,jpeg,jpg,pdf,docx,doc) format\n\n";
            Swal.fire({
                position: 'center',
                icon: "warning",
                text: txt,
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                willClose: () => {
                    if (typeof callback === 'function') {
                        callback();
                    }
                }
            });
            $('#fileOpen').val(null);
        }else{
            $('#fileName').html("<b>File: </b>" + fileName);
        }
    });
});

const updateAssignModal = "#updateAssignModal";
const updateAssignForm = "#updateAssignForm";

const updateStatusModal = "#updateStatusModal";
const updateStatusForm = "#updateStatusForm";

function clearForm() {
    $(updateAssignForm).find("#note").val("");
}

window.clickUpdateAssignAction = function () {
    clearValidation(updateAssignForm);
    clearForm();
    $(updateAssignModal).modal('show');
}

window.clickUpdateStatus = function () {
    clearValidation(updateStatusForm);
    $(updateStatusModal).modal('show');
}

$('#ticketMessage').summernote({
    height: 320
});
