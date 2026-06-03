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