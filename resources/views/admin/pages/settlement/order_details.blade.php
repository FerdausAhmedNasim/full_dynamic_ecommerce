@extends('admin.layouts.master')

@section('title', 'Settlements Order Details')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Settlements Details' )) }}</h4>
        </div>
    </div>

    <input type="hidden" value="{{ $settlement->id }}" name="settlement" id="settlementId" />

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="dataTable" class="table table-bordered ticket-data-table">
                <thead>
                    <tr>
                        {{-- <th>Settlement Id</th> --}}
                        <th>Settlement Date</th>
                        <th>Order</th>
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
@vite('resources/admin_assets/js/pages/settlement/order_details.js')

<script>
    window.changeStatus = function (e, route) {
        e.preventDefault();
        confirmFormModal(route, 'Confirmation', 'Are you sure Update Status.');
        table.ajax.reload();
    }
</script>
@endpush
