let columns = [
    {data: 'DT_RowIndex'},
    {data: 'name'},
    {data: 'phone'},
    {data: 'email'},
    {data: 'address'},
    {data: 'contact_person'},
    {data: 'operator'},
    {data: 'is_active'},
    {data: 'action', name: 'action', orderable: false, searchable: false, responsive:true},
];
let column_defs = [
    { targets: 4, visible: false },
    { targets: 5, visible: false },
    { targets: 6, visible: false },
    {"className": "text-center", "targets": [0,2,3,4,7,8]}
];

var table = $('#dataTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/supplier",
        data: function (d) {
            d.status    = $("#userStatus").val()
            d.is_deleted = $("#isDeleted").val()
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
        { html: '<a class="dt-button buttons-collection" href="'+ BASE_URL +'/supplier/create"><i class="fas fa-plus"></i> Add New</a>' }
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

window.filterStatus = function (status, type = '') {
    if(type == 'is_deleted')
    {
        $("#isDeleted").val(1);
    }
    else{
        $("#userStatus").val(status);
        $("#isDeleted").val(0);
    }
    table.ajax.reload();
}

window.changeStatus = function (e, route)
{
    e.preventDefault();
    confirmFormModal(route, 'Confirmation', 'Are you sure Update Status. ');
    table.ajax.reload();
}
