@extends('admin.pages.config.area_settings.layout.master')

@section('title', 'Division')
@section('division', 'active')

@section('areaSettingsContent')

    <input type="hidden" name="division" value="division">

    <table id="dataTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Division Name</th>
                <th>Status</th>
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
    @vite('resources/admin_assets/js/pages/areaSettings/division/index.js')
@endpush
