let columns = [
    {data: 'settlement_number'},
    {data: 'settlement_date'},
    {data: 'total_seller'},
    {data: 'total_sale'},
    {data: 'commission'},
    {data: 'ad_cost'},
    {data: 'total_amount'},
    {data: 'start_date'},
    {data: 'end_date'},
    {data: 'action', name: 'action', orderable: false, searchable: false, responsive:true},
];

let column_defs = [
    {"className": "text-center", "targets": [0,1,2,3,4,9]}
];

var table = $('#dataTable').DataTable({
    order: false,
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/settlements",
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


window.showNote = function (id)
{
    const url = BASE_URL + '/payouts/' + id + '/get-message';
    axios.get(url)
        .then(response => {
            const data = response.data;
            $("#note").html(data.note);

            $(noteModal).modal('show');
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
