let userId = $("#userId").val();

let columns = [
    {data: 'DT_RowIndex'},
    {data: 'invoice_id'},
    {data: 'date_time'},
    {data: 'customer_id'},
    {data: 'sub_total_amount'},
    {data: 'total_amount'},
    {data: 'discount_amount'},
    {data: 'order_status'},
    {data: 'payment_status'},
    {data: 'payment_type'},
    {data: 'operator_id'},
    {data: 'action', name: 'action', orderable: false, searchable: false, responsive:true},
];

let column_defs = [
    { targets: 3, visible: false },
    { targets: 10, visible: false },
    {"className": "text-center", "targets": [0,2,3,7,8,9,10,11]},
    {"className": "text-right", "targets": [4,5,6]}
];

var table = $('#dataTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/users/sellers/orders/"+ userId,
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

