let columns = [
    { data: 'id' },
    { data: 'name' },
    { data: 'email' },
    { data: 'phone' },
    { data: 'user_type' },
    { data: 'status' },
    { data: 'dob' },
    { data: 'gender' },
    { data: 'entitlement_to_work' },
    { data: 'job_title' },
    { data: 'employment_type' },
    { data: 'employee_id' },
];
let column_defs = [
    { targets: 7, visible: false },
    { targets: 8, visible: false },
    { targets: 9, visible: false },
    { targets: 10, visible: false },
    { "className": "text-center", "targets": [0,5] }
];

var table = $('#usersReportDataTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/report/users",
        data: function (d) {
            d.type   = $("#type").val()
            d.status = $("#status").val()
            d.fromDate = $("#fromDate").val()
            d.toDate = $("#toDate").val()
        }
    },
    aLengthMenu: [
        [10, 50, 100, 200, 500, -1],
        [10, 50, 100, 200, 500, "All"]
    ],
    columns: columns,
    dom: 'Bfrtip',
    buttons: [
        'pageLength',
        {
            text: '<i class="fas fa-download"></i> Export',
            extend: 'collection',
            className: 'custom-html-collection pull-right',
            buttons: [
                'pdf',
                'csv',
                'excel',
            ]
        },
        { html: colVisibility('#usersReportDataTable', column_defs) },

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

$(document).ready(function () {
    $('#type').select2({
        placeholder: "Select User Type",
        allowClear: false,
        multiple: true,
    });
    $('#type').siblings('.select2-container').append('<span class="select-all"><i class="fa-regular fa-square-check"></i></span>');

    $('#status').select2({
        placeholder: "Select Status",
        allowClear: false,
        multiple: true,
    });
    $('#status').siblings('.select2-container').append('<span class="select-all"><i class="fa-regular fa-square-check"></i></span>');
});

window.filterUsers = function () {
    table.ajax.reload();
}

window.filterClear = function () {
    $('#type').val([]).trigger('change');
    $('#status').val([]).trigger('change');
    $('input[name="date_range"]').val([]);

    table.ajax.reload();
}
