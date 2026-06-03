let column_defs = [];

var table1 = $('#assetAssignDataTable1').DataTable({
    order: [[0, 'asc']],
    processing: true,
    responsive: true,
    autoWidth: false,
    dom: 'Bfrtip',
    buttons: [
        'pageLength',
        colVisibility('#assetAssignDataTable1', column_defs),
        '<a class="dt-button buttons-collection" id="acceptAll" href="#" onclick="openAcceptStockModal()"><i class="fas fa-check"></i> Accept All</a>'
    ],
    columnDefs: column_defs,
    language: {
        searchPlaceholder: "Search records",
        search: "",
        buttons: { pageLength: { _: "%d Rows", } }
    }
});
