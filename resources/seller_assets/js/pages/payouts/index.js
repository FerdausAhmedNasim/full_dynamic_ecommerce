let columns = [
    {data: 'id'},
    {data: 'created_at'},
    {data: 'amount'},
    {data: 'note'},
    {data: 'approved_by'},
    {data: 'status'},
    {data: 'action', name: 'action', orderable: false, searchable: false, responsive:true},
];

let column_defs = [
    {"className": "text-center", "targets": [0,2,5,6]},
];

var table = $('#dataTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/payouts",
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
        { html: '<button type="button" class="dt-button buttons-collection" onclick="clickCreateModal()"><i class="fas fa-plus"></i>Add New</button>' },
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


const createPayoutModal = "#createPayoutModal";
const createPayoutForm = "#createPayoutForm";
const updatePayoutModal = "#updatePayoutModal";
const updatePayoutForm = "#updatePayoutForm";

window.clickCreateModal = function ()
{
    clearValidation(createPayoutForm);

    $("#createAmount").val('');
    $("#createNote").val('');

    $(createPayoutModal).modal('show');
}

window.clickEditModal = function (id)
{
    loading('show');
    const url = BASE_URL + '/payouts/' + id + '/edit';
    axios.get(url)
        .then(response => {
            const data = response.data;
            clearValidation(updatePayoutForm);
            $("#payoutId").val(data.id);
            $("#updateAmount").val(data.amount);
            $("#updateNote").val(data.note);
            $(updatePayoutModal).modal('show');
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

function unparam(query) {
    var pairs = query.split('&');
    var result = {};
    pairs.forEach(function(pair) {
        pair = pair.split('=');
        result[pair[0]] = decodeURIComponent(pair[1] || '');
    });

    return result;
}

window.storePayout = function (e, t)
{
    e.preventDefault();
    const url = BASE_URL + '/payouts/store';
    var form_data = $(t).serialize();
    var formObject = unparam(form_data);

    if (formObject.current_balance == 0 || formObject.amount > formObject.current_balance) {
        notify(`You don't have sufficient balance.`, 'error');
        return;
    }

    loading('show');

    axios.post(url, form_data)
        .then(response => {
            $(createPayoutModal).modal('hide');
            notify(response.data.message, 'success');
            table.ajax.reload();
        })
        .catch(error => {
            const response = error.response;
            if (response) {
                if (response.status === 422)
                    validationForm(createRoleForm, response.data.errors);
                else
                    notify(response.data.message, 'error');
            }
        })
        .finally(() => {
            loading('hide');
        });
}

window.updatePayout = function (e, t)
{
    e.preventDefault();
    const id = $(updatePayoutForm).find("input[name='id']").val();

    const url = BASE_URL + '/payouts/' + id + '/update';
    var form_data = $(t).serialize();

    loading('show');
    axios.post(url, form_data)
        .then(response => {
            $(updatePayoutModal).modal('hide');
            notify(response.data.message, 'success');
            table.ajax.reload();
        })
        .catch(error => {
            const response = error.response;
            if (response) {
                if (response.status === 422)
                    validationForm(updatePayoutForm, response.data.errors);
                else
                    notify(response.data.message, 'error');
            }
        })
        .finally(() => {
            loading('hide');
        });
}

window.readMore = function (note)
{
    $("#note").html(note);

    $(noteModal).modal('show');
}
