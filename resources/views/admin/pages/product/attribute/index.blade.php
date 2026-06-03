
<table id="dataTable" class="table table-bordered ticket-data-table">
    <thead>
        <tr>
            <th>#SL</th>
            <th>Name</th>
            <th>Values</th>
            <th>Status</th>
            <th width="100px">Action</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>


@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')

@push('scripts')
@vite('resources/admin_assets/js/pages/product/attribute/index.js')
@endpush


@push('styles')
    <style>
        .custom-switch, .custom-control-label {
            cursor: pointer;
        }

        /* tooltip */
        .switch .tooltiptext {
            visibility: hidden;
        }

        .custom-switch .tooltiptext {
            visibility: hidden;
            width: auto;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            border-radius: 8px;
            padding: 7px 10px;
            position: absolute;
            z-index: 1;
            bottom: 27px;
            left: calc(0% - 20px);
        }

        .custom-switch .tooltiptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #007bff transparent transparent transparent;
        }

        .custom-switch:hover .tooltiptext {
            visibility: visible;
        }
    </style>
@endpush