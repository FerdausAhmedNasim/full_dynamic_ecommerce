let userId = $("#userId").val();

let columns = [
    { data: 'id' },
    { data: 'type' },
    { data: 'amount' },
    { data: 'dr_cr' },
    { data: 'date' },
    { data: 'sent_by' },
    { data: 'received_by' },
    { data: 'payment_method' },
    { data: 'transaction_id' },
];
let column_defs = [
    {"className": "text-center", "targets": [0,2,3,4]}
];

var ticketTable = $('#dataTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/users/sellers/"+ userId + "/balance-history",
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
        { html: colVisibility('#DataTable', column_defs) },
    ],
    columnDefs: column_defs,
    language: {
        searchPlaceholder: "Search records",
        search: "",
        buttons: {
            pageLength: {
                _: "%d rows",
            }
        }
    }
});

executeColVisibility(ticketTable);
// End Tables
