@extends('admin.layouts.master')
@section('title', 'Products')
@section('products', 'active')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.user.seller.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Products' )) }}</h4>
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
            <table id="dataTable" class="table table-bordered ticket-data-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Unit</th>
                        {{-- <th>Model</th> --}}
                        <th>Image</th>
                        <th>Active</th>
                        <th>Featured</th>
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

@include('admin.pages.product.partials.discount_modal')
@include('admin.assets.preview-image')
@stop

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')
@include('admin.assets.select2')
@include('admin.assets.datetimepicker')

@push('scripts')
@vite('resources/admin_assets/js/pages/user/seller/product/index.js')

<script>
    $(document).ready(function() {
        var ezzicoDiscount = {};
        ezzicoDiscount.opens = 'right',
                ezzicoDiscount.minDate = new Date(),
                ezzicoDiscount.locale = {
                    format: inputDateFormat,
                    separator: ' - ',
                    applyLabel: 'Apply',
                    cancelLabel: 'Cancel',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: 'Custom',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    firstDay: 1
                }

        $('#daterangepicker-for-discount').daterangepicker(ezzicoDiscount, function(start, end, label) {
            $('#fromDate').val(start.format('YYYY-MM-DD'));
            $('#toDate').val(end.format('YYYY-MM-DD'));
        });

        // Date range value clear
        $('#daterangepicker-for-discount').val("");
        $('#daterangepicker-for-discount').on('cancel.daterangepicker', function(ev, picker) {
            $('#daterangepicker-for-discount').val("");
            $('#fromDate').val('');
            $('#toDate').val('');
        });
    });

    window.addDiscount = (product_id) => {
        $('#product_id').val(product_id);
        $("#ezzicoDiscount").show()
    }
    window.closeModal = () => {
        $("#ezzicoDiscount").hide()
    }
</script>
@endpush

@push('styles')
<style>
    /* Start Custom Switch */
    .custom-switch {
        padding-left: 0.25rem;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        margin: 0;
    }

    .custom-switch-input {
        position: absolute;
        z-index: -1;
        opacity: 0;
    }

    .custom-switch-indicator {
        display: inline-block;
        height: 1.25rem;
        width: 2.25rem;
        background: #e9ecef;
        border-radius: 50px;
        position: relative;
        vertical-align: bottom;
        border: 1px solid rgba(0, 40, 100, 0.12);
        transition: 0.3s border-color, 0.3s background-color;
    }

    .custom-switch-indicator:before {
        content: "";
        position: absolute;
        height: calc(1.25rem - 4px);
        width: calc(1.25rem - 4px);
        top: 1px;
        left: 1px;
        background: #fff;
        border-radius: 50%;
        transition: 0.3s left;
    }

    .custom-switch-input:checked~.custom-switch-indicator {
        background: var(--btn-primary);
    }

    .custom-switch-input:checked~.custom-switch-indicator:before {
        left: calc(1rem + 1px);
    }

    .custom-switch-description {
        color: #6e7687;
        margin-left: 0.5rem;
        font-size: 0.875rem;
        transition: 0.3s color;
    }

    .custom-switch-input:checked~.custom-switch-description {
        color: #1e1f21;
    }

    .cursor-not-allowed {
        cursor: not-allowed !important;
    }
    table .custom_span {
        display: block !important;
        margin-bottom: -10px;
    }
</style>
@endpush
