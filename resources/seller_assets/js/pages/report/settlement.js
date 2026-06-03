let columns = [
    {data: 'settlement_number'},
    {data: 'settlement_date'},
    {data: 'total_sale'},
    {data: 'commission'},
    {data: 'ad_cost'},
    {data: 'amount'},
    {data: 'start_date'},
    {data: 'end_date'}
];

let column_defs = [
    { "className": "text-right", "targets": [2,3,4,5] }
];

var table = $('#dataTable').DataTable({
    order: false,
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/report/settlements",
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
