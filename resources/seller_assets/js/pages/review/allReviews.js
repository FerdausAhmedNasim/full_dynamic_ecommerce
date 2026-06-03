

let columns = [
    {data: 'product_id'},
    {data: 'customer_id'},
    {data: 'rating'},
    {data: 'active'},
    {data: 'comment'},
];

let column_defs = [
    {"className": "text-start", "targets": [0,1]},
    {"className": "text-center", "targets": [2,3]},
];

var table = $('#dataTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + '/products/reviews',
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


window.showComment = function (id)
{
    const url = BASE_URL + '/products/' + id + '/get-message';
    axios.get(url)
        .then(response => {
            const data = response.data;
            $("#comment").html(data.comment);

            $(commentModal).modal('show');
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

window.changeReviewStatus = function (e, route)
{
    e.preventDefault();
    confirmFormModal(route, 'Confirmation', 'Are you sure Update Status.');
    table.ajax.reload();
}