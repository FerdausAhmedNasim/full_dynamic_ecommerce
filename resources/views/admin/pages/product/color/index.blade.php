
<table id="dataTable" class="table table-bordered ticket-data-table">
    <thead>
        <tr>
            <th>#SL</th>
            <th>Name</th>
            <th>Color Code</th>
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
@vite('resources/admin_assets/js/pages/product/color/index.js')
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
            bottom: 30px;
            left: calc(30% - 23px);
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

        /* Color Code Tooltip  */
        .colorCodeToolTip {
            visibility: hidden;
        }
        .custom-color-code {
            position: relative;
            z-index: 1;
            display: block;
            min-height: 1.5rem;
            padding-left: 0rem;
            color-adjust: exact;
        }

        .custom-color-code .colorCodeToolTip {
            visibility: hidden;
            width: auto;
            color: #fff;
            text-align: center;
            border-radius: 8px;
            padding: 7px 10px;
            position: absolute;
            z-index: 1;
            bottom: 30px;
            left: calc(45% - 15px);
        }

        .custom-color-code:hover .colorCodeToolTip {
            visibility: visible;
        }

        .color-code {
            cursor: pointer;
        }

    </style>
@endpush