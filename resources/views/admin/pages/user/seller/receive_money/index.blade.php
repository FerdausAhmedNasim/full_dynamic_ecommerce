@extends('admin.layouts.master')
@section('title', 'Receive Money')
@section('receiveMoney', 'active')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.user.seller.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Receive Money' )) }}</h4>
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
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Sent By</th>
                        <th>Payment Method</th>
                        <th>Transaction Id</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('admin.pages.user.seller.receive_money.note-modal')

@stop

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')

@push('scripts')
@vite('resources/admin_assets/js/pages/user/seller/receive_money/index.js')
@endpush
