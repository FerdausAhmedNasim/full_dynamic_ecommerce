
let Id = $("#id").val();
let columns = [
    {data: 'id'},
    {data: 'user_id'},
    {data: 'email'},
    {data: 'user_status'},
    {data: 'send_status'},
    {data: 'action'},
];

let column_defs = [
    {"className": "text-center", "targets": [0,2,3,4]}
];

var table = $('#dataTable').DataTable({
    order: [[0, 'asc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/notifications/" + Id + "/show",
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
                _: "%d Rows",
            }
        }
    }
});

executeColVisibility(table);
// End Tables

window.resendEmail = function (id)
{
    loading('show');
    const url = BASE_URL + '/notifications/' + id + '/resend-api';
    axios.post(url)
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

