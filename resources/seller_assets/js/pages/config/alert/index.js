let columns = [
    {data: 'id'},
    {data: 'name'},
    {data: 'parent_id'},
    {data: 'details'},
    {data: 'action', name: 'action', orderable: false, searchable: false, responsive:true},
];

let column_defs = [
    // { targets: 4, visible: false },
    {"className": "text-center", "targets": [0, 4]}
];

var table = $('#dataTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/configs/more-settings/alert",
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
        { html: '<a class="dt-button buttons-collection" href="'+ BASE_URL +'/configs/more-settings/alert/create"><i class="fas fa-plus"></i> Add New</a>' }
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

window.showAlertDetails = function (id) {
    loading('show');
    axios.get(BASE_URL + '/configs/more-settings/alert/' + id + '/show')
    .then(response => {

        $('#title').text(response.data.data.name);
        $('#details').text(response.data.data.details);
        $('#alertDetailsModal').modal('show');
    })
    .catch(error => {
        if (error.response) {
            notify(response.data.message, 'error');
        }
    })
    .finally(() => {
        loading('hide');
    });
}

window.deleteAlert = function (id)
{
    loading('show');

    axios.post(BASE_URL + '/configs/more-settings/alert/' + id + '/delete')
        .then(response => {
            notify(response.data.message, 'success');
            table.ajax.reload();
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
