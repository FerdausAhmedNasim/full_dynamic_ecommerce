let columns = [
    {data: 'DT_RowIndex'},
    {data: 'invoice_id'},
    {data: 'supplier_id'},
    {data: 'supplier_mobile'},
    {data: 'sub_total_amount'},
    {data: 'vat_amount'},
    {data: 'packaging_cost'},
    {data: 'delivery_cost'},
    {data: 'discount_amount'},
    {data: 'return_amount'},
    {data: 'due_amount'},
    {data: 'total_amount'},
    {data: 'operator_id'},
    {data: 'action', name: 'action', orderable: false, searchable: false, responsive:true},
];

let column_defs = [
    { targets: 6, visible: false },
    { targets: 12, visible: false },
    {"className": "text-center", "targets": [0, 2, 3, 13]},
    {"className": "text-right", "targets": [4,5,6,7,8,9,10,11]}
];

var table = $('#dataTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/purchase"
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
        { html: '<a class="dt-button buttons-collection" href="'+ BASE_URL +'/purchase/create"><i class="fas fa-plus"></i> Add Purchase </a>' }
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
