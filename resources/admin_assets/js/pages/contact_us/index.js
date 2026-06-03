let columns = [
    {data: 'DT_RowIndex'},
    {data: 'name'},
    {data: 'email'},
    {data: 'subject'},
    {data: 'is_replied'},
    {data: 'created_at'},
    {data: 'action', name: 'action', orderable: false, searchable: false, responsive:true},
];
let column_defs = [
    { targets: 1, visible: true },
    {"className": "text-center", "targets": [0,4,5,6]}
];

var table = $('#dataTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/contactUs",
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

window.changeRepliedStatus = function (e, route)
{
    e.preventDefault();
    confirmFormModal(route, 'Confirmation', 'Are you sure Update Status.');
    table.ajax.reload();
}


window.showModal = function (id)
{
    loading('show');
    const url = BASE_URL + '/contactUs/' + id + '/get-message';
    axios.get(url)
        .then(response => {
            const data = response.data;
            $("#subject").html(data.subject);
            $("#message").html(data.message);

            $(showMessage).modal('show');
        })
        .catch(error => {
            const response = error.response;
            if (response)
                notify(response.data.message, 'error');
        })
        .finally(() => {
            loading('hide');
        });

}


