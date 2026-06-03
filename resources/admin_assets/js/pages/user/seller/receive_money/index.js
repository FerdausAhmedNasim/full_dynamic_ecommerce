let userId = $("#userId").val();

let columns = [
    { data: 'id' },
    { data: 'amount' },
    { data: 'date' },
    { data: 'operator_id' },
    { data: 'payment_method' },
    { data: 'transaction_id' },
    { data: 'note' },
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
        url: BASE_URL + "/users/sellers/"+ userId + "/receive-money",
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
        { html: '<a class="dt-button buttons-collection" href="'+ BASE_URL + '/users/sellers/'+ userId + '/receive-money/create"><i class="fas fa-plus"></i> Add New</a>' }
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

window.show = function (id) {
    loading('show');
    axios.post(BASE_URL + "/users/sellers/notes/"+ id + "/show")
        .then(response => {
            console.log(response.data.description);
            $("#noteTitle").html(response.data.title);
            $("#noteDescription").html(response.data.description);
           $("#showNote").modal('show');
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

window.showText = function (id)
{
    const url = BASE_URL + "/users/sellers/"+ userId + "/receive-money/show/" + id;

    axios.get(url)
        .then(response => {
            const data = response.data;
            $("#showText").html(data.note);

            $('#showTextModal').modal('show');
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


