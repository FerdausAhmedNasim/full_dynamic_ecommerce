let employeeId = $("#employeeId").val();

let columns = [
    { data: 'id' },
    { data: 'subject' },
    { data: 'full_name' },
    { data: 'department' },
    { data: 'assign_to' },
    { data: 'priority' },
    { data: 'status' },
    { data: 'created_by' },
    { data: 'last-reply' },
    { data: 'created_at' },
    {
        data: 'action',
        orderable: false,
        searchable: false,
        responsive:true
    },
];
let column_defs = [
    {"className": "text-center", "targets": [0,2,3,4,5,6,10]}
];

var ticketTable = $('#ticketDataTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/users/employees/" + employeeId + "/tickets",
        data: function (d) {
            d.status = $("#ticketStatus").val()
        }
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
        { html: colVisibility('#ticketDataTable', column_defs) },
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

executeColVisibility(ticketTable);
// End Tables

window.filterStatus = function (status = '') {
    $("#ticketStatus").val(status)
    ticketTable.ajax.reload();
}
