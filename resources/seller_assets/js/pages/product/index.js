$(document).ready(function () {
    $("#categories").select2({
        placeholder: "Select Category",
        allowClear: true
    });
    $("#product_sorting").select2({
        placeholder: "Select One",
        allowClear: true
    });
});

let columns = [
    {data: 'id'},
    {data: 'title'},
    {data: 'category_id'},
    {data: 'details'},
    {data: 'current_stock'},
    {data: 'approved'},
    {data: 'status'},
    {data: 'refundable'},
    {data: 'showHomePage'},
    {data: 'action', name: 'action', orderable: false, searchable: false, responsive:true},
];

let column_defs = [
    { targets: 7, visible: false },
    {"className": "text-center", "targets": [0,4,5,6,7,8]}
];

var table = $('#dataTable').DataTable({
    order: false,
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/products",
        data: function (d) {
            d.status      = $("#productStatus").val()
            d.category_id = $("#categoryId").val()
            d.sorting     = $("#productSorting").val()
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
        { html: '<a class="dt-button buttons-collection" href="'+ BASE_URL +'/products/create"><i class="fas fa-plus"></i> Add New</a>' }
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

window.filterStatus = function (status) {
    if (status) {
        $("#productStatus").val(status);
    }

    table.ajax.reload();
}

$(document).on('change', '#categories', function (e) {
    if ($(this).val()) {
        $("#categoryId").val($(this).val());
    }

    table.ajax.reload();
});

$(document).on('change', '#product_sorting', function (e) {
    if ($(this).val()) {
        $("#productSorting").val($(this).val());
    }

    table.ajax.reload();
});

window.changeStatus = function (e, route, confirmation_msg) {
    e.preventDefault();
    table.ajax.reload();
    confirmFormModal(route, 'Confirmation', confirmation_msg);
}
