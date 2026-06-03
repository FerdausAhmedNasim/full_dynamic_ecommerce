@extends('admin.pages.config.area_settings.layout.master')

@section('title', 'Area')
@section('area', 'active')

@section('areaSettingsContent')

    <input type="hidden" name="area" value="area">

    <table id="dataTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Area Name</th>
                <th>Thana Name</th>
                <th>District Name</th>
                <th>Division Name</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

@endsection

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')

@push('scripts')
    @vite('resources/admin_assets/js/pages/areaSettings/area/index.js')
@endpush
