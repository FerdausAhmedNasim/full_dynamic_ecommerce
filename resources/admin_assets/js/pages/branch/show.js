$(document).ready(function () {
    $("#employee_id").select2({
        placeholder: "Select One",
        allowClear: true,
    });

    $("#employeeID").select2({
        placeholder: "Select One",
        allowClear: true,
    });
});

let branchId = $("#branchId").val();;

let column_defs = [
    {"className": "text-center", "targets": [0,3]}
];

var table = $('#dataTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    responsive: true,
    autoWidth: false,
    dom: 'Bfrtip',
    buttons: [
        'pageLength',
        { html: colVisibility('#dataTable', column_defs) },
        { html: '<button type="button" class="dt-button buttons-collection" onclick="clickAddAction()"><i class="fas fa-plus"></i>Add New</button>' }
    ],
    columnDefs: column_defs,
    language: {
        searchPlaceholder: "Search records",
        search: "",
        buttons: {
            pageLength: {
                _: "%d Rows",
            }
        }
    }
});

executeColVisibility(table);
// End Tables


window.changeStatus = function (e, route)
{
    e.preventDefault();
    confirmFormModal(route, 'Confirmation', 'Are you sure Update Status. ');
}


// Create Branch Employee Modal
window.clickAddAction = function ()
{
    $("#createBranchEmployeeModal").modal('show');
}

// Create Branch Employee
window.createBranchEmployee = function (e, t)
{
    e.preventDefault();
    const url = BASE_URL + '/branches/' + branchId + '/employee';
    var form_data = $(t).serialize();

    loading('show');
    axios.post(url, form_data)
        .then(response => {
            $(createBranchEmployeeModal).modal('hide');
            notify(response.data.message, 'success');
            location.reload();
        })
        .catch(error => {
            const response = error.response;
            if (response) {
                if (response.status === 422)
                    validationForm(createBranchEmployeeForm, response.data.errors);
                else
                    notify(response.data.message, 'error');
            }
        })
        .finally(() => {
            loading('hide');
        });
}

// Edit Branch Employee Modal
window.clickEditAction = function (id)
{
    loading('show');
    const url = BASE_URL + '/branches/user/employee/' + id + '/edit';
    axios.get(url)
        .then(response => {
            const data = response.data;

            $(updateBranchEmployeeForm).find("input[name='id']").val(data.id);
            $(updateBranchEmployeeForm).find("input[name='employee_id']").val(data.employee_id);

            $("#employeeID").val(data.employee_id).trigger('change');

            $("#updateBranchEmployeeModal").modal('show');
        })
        .catch(error => {
            const response = error.response;
            if (response)
                notify(response.data.message, 'error');
        })
        .finally(() => {
            loading('hide');
        });
}

// Update Branch Employee
window.updateBranchEmployee = function (e, t)
{
    e.preventDefault();
    const branch_id = $(updateBranchEmployeeForm).find("input[name='id']").val();

    const url = BASE_URL + '/branches/user/employee/' + branch_id + '/update';
    var form_data = $(t).serialize();

    loading('show');
    axios.post(url, form_data)
        .then(response => {
            $(updateBranchEmployeeModal).modal('hide');
            notify(response.data.message, 'success');
            location.reload();
        })
        .catch(error => {
            const response = error.response;
            if (response) {
                if (response.status === 422)
                    validationForm(updateBranchEmployeeForm, response.data.errors);
                else
                    notify(response.data.message, 'error');
            }
        })
        .finally(() => {
            loading('hide');
        });
}
