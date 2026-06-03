let columns = [
    {data: 'id'},
    {data: 'invoice_id'},
    {data: 'date_time'},
    {data: 'customer_id'},
    {data: 'customer_mobile'},
    {data: 'sub_total_amount'},
    {data: 'discount_amount'},
    {data: 'total_amount'},
    {data: 'order_status'},
    {data: 'payment_status'},
    {data: 'payment_type'},
    {data: 'action', name: 'action', orderable: false, searchable: false, responsive:true},
];

let column_defs = [
    { targets: 3, visible: false },
    { targets: 4, visible: false },
    {"className": "text-center", "targets": [0,1,2,7,8,9,10,11]},
    {"className": "text-right", "targets": [4,5,6]}
];

var table = $('#dataTable').DataTable({
    order: false,
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/order",
        data: function (d) {
            d.range    = $("#range").val()
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
            text : '<i class="fas fa-download"></i> Export',
            extend: 'collection',
            className: 'custom-html-collection pull-right',
            buttons: [
                'pdf',
                'csv',
                'excel',
            ]
        },
        { html: colVisibility('#dataTable', column_defs) }
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
    $('#range').select2({
        placeholder: "Select One",
        allowClear: false,
        multiple: false,
    });
    $('#range').siblings('.select2-container').append('<span class="select-all"><i class="fa-regular fa-square-check"></i></span>');
});

$(document).ready(function () {
    $('#status').select2({
        placeholder: "Select Status",
        allowClear: false,
        multiple: true,
    });
    $('#status').siblings('.select2-container').append('<span class="select-all"><i class="fa-regular fa-square-check"></i></span>');
});

window.filterOrders = function () {
    table.ajax.reload();
}

window.filterClear = function () {
    $('#range').val([]).trigger('change');
    $('#status').val([]).trigger('change');
    $('input[name="date_range"]').val([]);
    table.ajax.reload();
}
