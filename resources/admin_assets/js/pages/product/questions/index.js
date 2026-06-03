var product_id = $('#product_id').val();

let columns = [
    {data: 'id'},
    {data: 'customer_id'},
    {data: 'comment'},
    {data: 'active'},
    {data: 'answer'},
    {data: 'action', name: 'action', orderable: false, searchable: false, responsive:true},
];

let column_defs = [
    {"className": "text-center", "targets": [0,2,5]},
];

var table = $('#dataTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/products/" + "questions/" + product_id,
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
        // { html: '<button type="button" class="dt-button buttons-collection" onclick="clickCreateModal()"><i class="fas fa-plus"></i>Add New</button>' },
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

// Change Status
window.changeStatus = function (e, route, confirmation_msg) {
    e.preventDefault();

    table.ajax.reload();

    confirmFormModal(route, 'Confirmation', confirmation_msg);
}

// Giving Answer
const answerModal = "#answerModal";
const answerForm = "#answerForm";

window.clickAnswerModal = function (id)
{
    loading('show');
    const url = BASE_URL + '/products/' + 'questions/' + product_id + '/answer/' + id;
    axios.get(url)
        .then(response => {
            const data = response.data;

            console.log(data);

            clearValidation(answerForm);
            $("#question_id").val(data.id);
            $("#question").val(data.comment);
            $(answerModal).modal('show');
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

window.storeAnswer = function (e, t)
{
    e.preventDefault();
    const id = $(answerForm).find("input[name='id']").val();

    const url = BASE_URL + '/products/' + 'questions/' + product_id+ '/store_answer/' + id ;
    var form_data = $(t).serialize();

    loading('show');
    axios.post(url, form_data)
        .then(response => {
            $(answerModal).modal('hide');
            notify(response.data.message, 'success');

            $('#question_id').val('');
            $('#question').val('');
            $('#answer').val('');

            table.ajax.reload();
        })
        .catch(error => {
            const response = error.response;
            if (response) {
                if (response.status === 422)
                    validationForm(answerForm, response.data.errors);
                else
                    notify(response.data.message, 'error');
            }
        })
        .finally(() => {
            loading('hide');
        });
}

window.readMore = function (answer)
{
    $("#showAnswer").html(answer);

    $(answerDetails).modal('show');
}