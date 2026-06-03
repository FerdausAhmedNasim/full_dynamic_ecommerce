let columns = [
    {data: 'id'},
    {data: 'manager_id'},
    {data: 'name'},
    {data: 'phone'},
    {data: 'email'},
    {data: 'balance'},
    {data: 'is_active'},
    {data: 'location_id'},
    {data: 'address'},
    {data: 'operator'},
    {data: 'action', name: 'action', orderable: false, searchable: false, responsive:true},
];
let column_defs = [
    { targets: 7, visible: false },
    {"className": "text-center", "targets": [0,8,9]},
    {"className": "text-right", "targets": [5]}
];

var table = $('#dataTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/branches",
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
        { html: '<a class="dt-button buttons-collection" href="'+ BASE_URL +'/branches/create"><i class="fas fa-plus"></i> Add New</a>' }
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

window.changeStatus = function (e, route)
{
    e.preventDefault();
    confirmFormModal(route, 'Confirmation', 'Are you sure Update Status. ');
    table.ajax.reload();
}
