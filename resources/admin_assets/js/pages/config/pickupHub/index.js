let columns = [
    {data: 'id'},
    {data: 'street_address'},
    {data: 'thana_id'},
    {data: 'area_id'},
    {data: 'note'},
    {data: 'action', name: 'action', orderable: false, searchable: false, responsive:true},
];

let column_defs = [
    // { targets: 4, visible: false },
    {"className": "text-center", "targets": [0, 2, 5]}
];

var table = $('#dataTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/configs/general-settings/pickup-hub/",
        complete: function() {
            toggleAddButton();
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
        { html: '<a id="addNewButton" class="dt-button buttons-collection" href="'+ BASE_URL +'/configs/general-settings/pickup-hub/create"><i class="fas fa-plus"></i> Add New</a>' }
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

// Function to hide the "Add New" button based on row count
function toggleAddButton() {
    let data = table.ajax.json();
    
    if (data && data.recordsTotal >= 1) {
        $('#addNewButton').hide();
    } else {
        $('#addNewButton').show();
    }
}

// Initial call to hide the button if needed
toggleAddButton();