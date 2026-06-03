@extends('admin.pages.config.area_settings.layout.master')

@section('title', 'District')
@section('district', 'active')

@section('areaSettingsContent')

    <input type="hidden" name="district" value="district">

    <table id="dataTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>District Name</th>
                <th>Division Name</th>
                <th class="text-center">Sub Dhaka</th>
                <th class="text-center">Status</th>
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
    @vite('resources/admin_assets/js/pages/areaSettings/district/index.js')
@endpush
