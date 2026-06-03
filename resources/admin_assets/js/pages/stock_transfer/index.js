let columns = [
    {data: 'id'},
    {data: 'stock_from_id'},
    {data: 'stock_to_id'},
    {data: 'product'},
    {data: 'branch_from_id'},
    {data: 'branch_to_id'},
    {data: 'quantity'},
    {data: 'date'},
    {data: 'note'},
    {data: 'operator_id'},
    // {data: 'action', name: 'action', orderable: false, searchable: false, responsive:true},
];
let column_defs = [
    { targets: 8, visible: false },
    { targets: 9, visible: false },
    {"className": "text-center", "targets": [0,1,5,8]}
];

var table = $('#dataTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/stock-transfer",
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
        { html: '<a class="dt-button buttons-collection" href="'+ BASE_URL +'/stock-transfer/create"><i class="fas fa-plus"></i> Add New</a>' }
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
