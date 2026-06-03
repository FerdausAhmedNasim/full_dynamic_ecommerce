let columns = [
    {data: 'DT_RowIndex'},
    {data: 'invoice_id'},
    {data: 'seller_name'},
    {data: 'sub_total_amount'},
    {data: 'shipping_cost'},
    {data: 'total_amount'},
    {data: 'payment_amount'},
    {data: 'status'},
    {data: 'operator_id'},
    {data: 'action', name: 'action', orderable: false, searchable: false, responsive:true},
];
let column_defs = [
    { targets: 6, visible: true },
    { targets: 8, visible: false },
    {"className": "text-center", "targets": [0,1,2,3,4,5,6,7,8,9]},
];

var table = $('#dataTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/returns",
        data: function (d) {
            d.seller     = $("#seller").val()
            d.status     = $("#status").val()
        },
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

const modalOrderGet = "#modalOrderGet";

function clearForm()
{
    $(modalOrderGet).find("input[name='invoice_id']").val('');
}

window.clickAddAction = function ()
{
    clearForm();
    $(modalOrderGet).modal('show');
}

window.getOrder = function (e, t)
{
    e.preventDefault();
    const url = BASE_URL + '/returns/sale/get';
    const form_data = $(t).serialize();
    loading('show');
    axios.post(url, form_data)
        .then(response => {
            let url = BASE_URL + '/returns/sale/'+ response.data.data +'/create';
            window.location =url;
            $(modalOrderGet).modal('hide');
        })
        .catch(error => {
            const response = error.response;
            if (response) {
                if (response.status === 422)
                    validationForm(modalOrderGet, response.data.errors);
                else
                    notify(response.data.message, 'error');
            }
        })
        .finally(() => {
            loading('hide');
        });
}
window.filterStatus = function (status, type = '')
{
    $("#status").val(status);
    table.ajax.reload();
}

$(document).on('change keyup', '#seller',function(){
    table.ajax.reload();
});

