@extends('admin.pages.config.general_settings.layout.master')
@section('title', 'Email Templates')
@section('email_template', 'active')

@section('settingsContent')

<div class="section-title mb-4 bar-before-title fw-bold">Email Templates</div>

<table id="dataTable" class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Key</th>
            <th>Updated At</th>
            <th width="100px">Action</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>


@stop

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')

@push('scripts')
@vite('resources/admin_assets/js/pages/config/email_template/index.js')
@endpush