@extends('admin.pages.config.general_settings.layout.master')

@section('title', 'System Details')

@section('settingsContent')

    <table id="dataTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Street Address</th>
                <th>Thana</th>
                <th>Area</th>
                <th>Note</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

@stop

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')

@push('scripts')
    @vite('resources/admin_assets/js/pages/config/pickupHub/index.js')
@endpush
