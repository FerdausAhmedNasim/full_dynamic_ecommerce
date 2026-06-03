@extends('admin.layouts.master')
@section('title', 'Category')
@section('category', 'active')
@section('content')

@php
use App\Library\Helper;
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Category' )) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.components.product_topbar')
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-body">

                    <table id="dataTable" class="table table-bordered ticket-data-table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Root Category</th>
                                <th>Slug</th>
                                <th>Thumbnail</th>
                                <th>Icon</th>
                                <th>Order</th>
                                <th>Featured</th>
                                <th>Status</th>
                                <th>Operator</th>
                                <th width="100px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        @if(Helper::hasAuthRolePermission('category_create'))
            @include('admin.pages.product.category.create')
        @endif

    </div>
</div>

@stop
@include('admin.assets.select2')
@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')

@push('scripts')
@vite('resources/admin_assets/js/pages/product/category/index.js')
@endpush