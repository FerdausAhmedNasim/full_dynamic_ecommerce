@extends('admin.layouts.master')

@section('title', 'Settlements Details')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Settlements Details' )) }}</h4>
        </div>
    </div>

    <input type="hidden" value="{{ $settlementDate }}" name="settlementDate" id="settlementDate" />

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="dataTable" class="table table-bordered ticket-data-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Settlement Date</th>
                        <th>Seller</th>
                        <th>Total Sale</th>
                        <th>Commission</th>
                        <th>AD Cost</th>
                        <th>Payable Amount</th>
                        <th>Current Balance</th>
                        <th>Money Sent</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('admin.pages.settlement.modal_change_status')
@include('admin.pages.settlement.note_modal')
@stop

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')

@push('scripts')
@vite('resources/admin_assets/js/pages/settlement/details.js')

<script>
    window.changeStatus = function (e, route) {
        e.preventDefault();
        confirmFormModal(route, 'Confirmation', 'Are you sure Update Status.');
        table.ajax.reload();
    }
</script>
@endpush
