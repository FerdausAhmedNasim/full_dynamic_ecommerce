@extends('admin.layouts.master')
@section('title', 'Seller Category')
@section('sellerCategory', 'active')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.user.seller.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Seller Category' )) }}</h4>
        </div>
    </div>

    <!-- TabMenu Start -->
    <div class="card shadow-sm">
        @include('admin.pages.user.seller.partials.topbar', ['user', $user??''])
    </div>
    <!-- TabMenu End -->

    <div class="card shadow-sm mt-3">
        <input type="hidden" name="userId" id="userId" value="{{ $user->id }}">
        <div class="card-body">
            <table id="dataTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th width="50px">No</th>
                        <th>Category</th>
                        <th>Commission Rate (%)</th>
                        <th>Created By</th>
                        <th>Created At</th>
                        <th width="100px">Action</th>
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
@vite('resources/admin_assets/js/pages/user/seller/category/index.js')
@endpush
