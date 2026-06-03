let columns = [
    {data: 'id'},
    {data: 'name'},
    {data: 'parent_id'},
    {data: 'slug'},
    {data: 'thumbnail'},
    {data: 'icon'},
    {data: 'order'},
    {data: 'featured'},
    {data: 'active'},
    {data: 'operator_id'},
    {data: 'action', name: 'action', orderable: false, searchable: false, responsive:true},
];
let column_defs = [
    { targets: 3, visible: false },
    { targets: 9, visible: false },
    {"className": "text-center", "targets": [0,2,3,4,5,6,7,8,9,10]}
];

var table = $('#dataTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/category",
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

window.changeActiveStatus = function (e, route)
{
    e.preventDefault();
    confirmFormModal(route, 'Confirmation', 'Are you sure Update Status.');
    table.ajax.reload();
}

window.changeFeaturedStatus = function (e, route)
{
    e.preventDefault();
    confirmFormModal(route, 'Confirmation', 'Are you sure Update Status.');
    table.ajax.reload();
}

