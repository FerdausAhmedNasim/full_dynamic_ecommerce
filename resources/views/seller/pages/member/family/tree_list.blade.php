@extends('admin.layouts.master')

@section('title', 'Family Member')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Family Member')) }}</h4>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <table id="dataTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Family ID</th>
                        <th>Family Member</th>
                        <th>Operator</th>
                        <th>Note</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop


@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')

@push('scripts')
@vite('resources/admin_assets/js/pages/member/family/familyTree.js')
@endpush
