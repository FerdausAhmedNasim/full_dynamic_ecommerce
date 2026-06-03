let MemberId = $("#MemberId").val();

let columns = [
    { data: 'id' },
    { data: 'alert_id' },
    { data: 'operator_id' },
    { data: 'created_at' },
    {
        data: 'action',
        orderable: false,
        searchable: false,
        responsive: true
    },
];

let column_defs = [
    { targets: 4, visible: true },
    { "className": "text-center", "targets": [0, 2, 3, 4] }
];

var clientAlertTable = $('#clientAlertTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/members/client_alert/" + MemberId,
        data: function (d) {
            d.status = $("#userStatus").val()
        }
    },
    columns: columns,
    dom: 'Bfrtip',
    buttons: [
        'pageLength',
        {
            text: '<i class="fas fa-download"></i> Export',
            extend: 'collection',
            className: 'custom-html-collection pull-right',
            buttons: [
                'pdf',
                'csv',
                'excel',
            ]
        },
        { html: colVisibility('#clientAlertTable', column_defs) },
        { html: '<a class="dt-button buttons-collection" href="#" onclick="addNewAlert()"><i class="fas fa-plus"></i> Add New</a>' },
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

executeColVisibility(clientAlertTable);
// End Tables

$(".close, .btn-close").on('click', function(){
    $(".modal").modal('hide');
});

const addNewClientAlert = "#addNewClientAlert";
window.addNewAlert = function () {
    $(addNewClientAlert).modal('show');
}

const editClientAlert = "#editClientAlert";
window.openEditModal = function (value, id) {
    var url = BASE_URL + "/members/client_alert/" + id + "/update";
    $("#alert_id").val(value);
    $('#editClientAlertForm').attr('action', url);

    $(editClientAlert).modal('show');
}

window.showAlertDetails = function (id) {

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

    });
}
