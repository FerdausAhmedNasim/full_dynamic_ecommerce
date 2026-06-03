@extends('seller.pages.member.layout.master')

@section('title', 'Client Alerts')

@section('clientContent')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-body py-sm-4">
                <div class="text-center pb-2">
                    <div class="mb-3">
                        <table class="table table-bordered" id="clientAlertTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Alert</th>
                                    <th>Operator</th>
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
        </div>
    </div>
</div>


@endsection

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')
@include('admin.assets.summernote-text-editor')
@include('admin.assets.select2')


@push('scripts')
@vite('resources/employee_assets/js/member/client_alert/index.js')
@endpush
<script src="{{ asset('assets/js/vendor.bundle.base.js') }}"></script>

@push('styles')
    <style>
        .count {
            top: -3px !important;
        }
    </style>
@endpush



