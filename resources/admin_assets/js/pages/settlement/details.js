let settlementDate = $('#settlementDate').val();

let columns = [
    {data: 'id'},
    {data: 'settlement_date'},
    {data: 'seller'},
    {data: 'total_sale'},
    {data: 'commission'},
    {data: 'ad_cost'},
    {data: 'amount'},
    {data: 'current_balance'},
    {data: 'money_sent'},
    {data: 'action'},
];

let column_defs = [
    {"className": "text-center", "targets": [0,8,9]},
    {"className": "text-right", "targets": [3,4,5,6,7]}
];

var table = $('#dataTable').DataTable({
    order: false,
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/settlements/" + settlementDate + "/details",
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
