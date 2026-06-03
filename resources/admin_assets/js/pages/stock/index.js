let columns = [
    {data: 'id'},
    {data: 'category'},
    {data: 'product'},
    {data: 'branch_id'},
    {data: 'quantity'},
    {data: 'purchase_price'},
    {data: 'sale_price'},
    {data: 'special_price'},
    {data: 'operator_id'},
    {data: 'action', name: 'action', orderable: false, searchable: false, responsive:true},
];
let column_defs = [
    { targets: 1, visible: true },
    { targets: 8, visible: false },
    {"className": "text-center", "targets": [0,2,3,4,9]},
    {"className": "text-right", "targets": [5,6,7]}
];

var table = $('#dataTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    // deferRender: true,
    ajax: {
        url: BASE_URL + "/stocks",
        data: function (d) {
            d.status    = $("#availableStock").val()
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
        { html: colVisibility('#dataTable', column_defs) },
        // { html: '<a class="dt-button buttons-collection" href="'+ BASE_URL +'/stocks/create"><i class="fas fa-plus"></i> Add New</a>' }
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

window.filterStatus = function (status) {

    $("#availableStock").val(status);

    table.ajax.reload();
}
