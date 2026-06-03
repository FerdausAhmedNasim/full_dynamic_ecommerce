let userId = $("#userId").val();

let columns = [
    {data: 'DT_RowIndex'},
    {data: 'invoice_id'},
    {data: 'sub_total_amount'},
    {data: 'total_amount'},
    {data: 'discount_amount'},
    {data: 'shipping_cost'},
    {data: 'order_status'},
    {data: 'payment_status'},
    {data: 'return_status'},
    {data: 'operator_id'},
    {data: 'action', name: 'action', orderable: false, searchable: false, responsive:true},
];

let column_defs = [
    { targets: 2, visible: true },
    {"className": "text-center", "targets": [0,6,7,8,9]},
    {"className": "text-right", "targets": [2,3,4,5]}
];

var table = $('#dataTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/users/customers/"+ userId +"/orders"
    },
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
        // { html: '<a class="dt-button buttons-collection" href="'+ BASE_URL +'/product/create"><i class="fas fa-plus"></i> Add New</a>' }
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

