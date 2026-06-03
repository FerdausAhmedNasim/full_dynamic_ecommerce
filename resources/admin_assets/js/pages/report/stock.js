let columns = [
    { data: 'product' },
    { data: 'stock' },
];

let column_defs = [
    { "className": "text-right", "targets": [1] },
];

var table = $('#stockReportDataTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/report/stock",
        data: function (d) {
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
        { html: colVisibility('#stockReportDataTable', column_defs) },

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
    $('#category').val('').trigger('change');
    $('input[name="date_range"]').val('');

    table.ajax.reload();
}
