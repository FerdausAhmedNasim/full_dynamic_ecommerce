@extends('admin.pages.config.area_settings.layout.master')

@section('title', 'Thana')
@section('thana', 'active')

@section('areaSettingsContent')

    <input type="hidden" name="thana" value="thana">

    <table id="dataTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Thana Name</th>
                <th>District Name</th>
                <th class="text-center">Sub Dhaka</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
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
    @vite('resources/admin_assets/js/pages/areaSettings/thana/index.js')
@endpush
