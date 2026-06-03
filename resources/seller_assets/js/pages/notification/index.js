let columns = [
    { data: 'id' },
    { data: 'subject' },
    { data: 'send_date' },
    { data: 'created_at' },
    { data: 'show' },
];
let column_defs = [
    { targets: 2, visible: true },
    {"className": "text-center", "targets": [0,1,2,3,4]}
];

var table = $('#dataTable').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/notifications",
        data: function (d) {
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
        { html: colVisibility('#dataTable', column_defs) },
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

executeColVisibility(table);
// End Tables

window.showComment = function (id)
{
    const url = BASE_URL + '/notifications/' + id;
    axios.get(url)
        .then(response => {
            $("#comment").html(response.data);

            $('#commentModal').modal('show');
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
