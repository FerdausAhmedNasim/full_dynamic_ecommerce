
@extends('seller.layouts.master')

@section('title', __('Product Reviews'))
@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Product Reviews')) }}</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-body py-sm-4">
                    <div class="text-start pb-2">
                        <div class="mb-3">
                            <table class="table table-bordered" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Customer</th>
                                        <th>Rating</th>
                                        <th>Status</th>
                                        <th>Comments</th>
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
</div>
@include('seller.components.review_model')
@stop

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')

@push('scripts')
@vite('resources/seller_assets/js/pages/review/allReviews.js')

@endpush
