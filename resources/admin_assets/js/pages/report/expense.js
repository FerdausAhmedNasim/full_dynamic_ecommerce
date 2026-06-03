let columns = [
    { data: 'id' },
    { data: 'category' },
    { data: 'title' },
    { data: 'amount' },
    { data: 'created_at' },
    { data: 'operator_id' },
];

let column_defs = [
    // { targets: 6, visible: false },
    { "className": "text-center", "targets": [0, 5] },
    { "className": "text-right", "targets": [3] }
];

var table = $('#expenseReportDataTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/report/expense",
        data: function (d) {
            d.branch_id   = $("#branch_id").val()
            d.category   = $("#category").val()
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
        { html: colVisibility('#expenseReportDataTable', column_defs) },

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
    $('#branch_id').select2({
        placeholder: "Select Branch",
        allowClear: false,
        multiple: true,
    });
    $('#branch_id').siblings('.select2-container').append('<span class="select-all"><i class="fa-regular fa-square-check"></i></span>');


    $('#category').select2({
        placeholder: "Select Category",
        allowClear: false,
        multiple: true,
    });
    $('#category').siblings('.select2-container').append('<span class="select-all"><i class="fa-regular fa-square-check"></i></span>');
});


window.filterUsers = function () {
    table.ajax.reload();
}

window.filterClear = function () {
    $('#branch_id').val('').trigger('change');
    $('#category').val('').trigger('change');
    $('input[name="date_range"]').val('');
    table.ajax.reload();
}
