@extends('admin.layouts.master')

@section('title', 'Manage Roles')

@section('content')

@php
    use App\Library\Helper;
    $user_role = App\Models\User::getAuthUser()->roles()->first();
    $hasPermission = Helper::hasAuthRolePermission('role_create');
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">MANAGE ROLES</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 ">
            <div class="card shadow-sm">
                <div class="card-body py-sm-4">
                    <ul class="nav nav-tab" id="tabMenu" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link default home" data-toggle="tab" href="#tab-employee-role" role="tab" aria-controls="One"
                                aria-selected="true">Employee Role
                            </a>
                        </li>

                        {{-- <li class="nav-item attendance">
                            <a class="nav-link" data-toggle="tab" href="#tab-seller-role" role="tab" aria-controls="Two"
                                aria-selected="false">Seller Role
                            </a>
                        </li> --}}
                    </ul>
                </div>
            </div>

            <div class="tab-content mt-4">

             <!-- Home -->
                <div class="tab-pane fade" id="tab-employee-role" role="tabpanel" aria-labelledby="tab-employee-role">
                    <div class="card shadow-sm">
                        <div class="card-body py-sm-4">
                            <table id="dataTableEmployeeRole" class="table display nowrap table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Name</th>
                                        <th class="text-center" width="100px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- <div class="tab-pane fade" id="tab-seller-role" role="tabpanel" aria-labelledby="tab-donations">
                    <div class="card shadow-sm">
                        <div class="card-body py-sm-4">
                            <table id="dataTableSellerRole" class="table display nowrap table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Name</th>
                                        <th class="text-center" width="100px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

</div>

@include('admin.pages.config.role.partial.employee_modal_create')
@include('admin.pages.config.role.partial.employee_modal_update')

@include('admin.pages.config.role.partial.seller_modal_create')
@include('admin.pages.config.role.partial.seller_modal_update')

@stop

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')

@push('scripts')
@vite('resources/admin_assets/js/pages/config/role/index.js')
@vite('resources/admin_assets/js/pages/config/role/seller.js')
@endpush
