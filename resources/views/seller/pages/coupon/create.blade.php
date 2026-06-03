@extends('seller.layouts.master')

@section('title', __('New Coupon'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('seller.coupon.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('New Coupon')) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('seller.coupon.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-sm-3">
                            <div class="form-group row @error('discount_type') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Coupon Type') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" name="discount_type" required>
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($couponTypes as $key => $coupon)
                                            <option class="text-capitalize" value="{{ $key }}" {{ (old("discount_type") == $key) ? "selected" : "" }}>
                                                {{ $coupon }}</option>
                                        @endforeach
                                    </select>
                                    @error('discount_type')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('code') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Coupon Code') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="code"
                                        value="{{ old('code') }}" placeholder="{{ __('CouponCode') }}" required>
                                    @error('code')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('discount') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Discount') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="discount"
                                        value="{{ old('discount') }}" placeholder="{{ __('Discount') }}" required>
                                    @error('discount')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('maximum_discount') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Maximum Discount') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="maximum_discount"
                                        value="{{ old('maximum_discount') }}" placeholder="{{ __('Maximum Discount') }}" required>
                                    @error('maximum_discount')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ __('Coupon Period') }}</label>
                                <div class="col-sm-9">
                                    <input type="hidden" id="fromDate" value="" name="start_date">
                                    <input type="hidden" id="toDate" value="" name="end_date">
                                    <div class="input-group with-icon">
                                        <input type="text" name="date_range" class="form-control" id="daterangepicker-for-coupon" value="{{ old('start_date') && old('end_date') ? App\Library\Helper::dateRange(old('start_date'), old('end_date')) : null }}" style="border-radius: 4px; background: #fff; color: #000;"
                                        placeholder="{{ inputDateFormat() }} - {{ inputDateFormat() }}" />
                                        <i class="date-icon fa-solid fa-calendar-days"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="modal-footer justify-content-center col-md-12">
                        {!! \App\Library\Html::btnReset() !!}
                        {!! \App\Library\Html::btnSubmit() !!}
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@include('admin.assets.select2')
@include('admin.assets.datetimepicker')

@push('scripts')
@vite('resources/admin_assets/js/select2.js')

<script>
    $(document).ready(function() {
        // date range picker only date format for coupon
        var couponOptions = {};
                couponOptions.opens = 'right',
                couponOptions.minDate = new Date(),
                couponOptions.locale = {
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

        $('#daterangepicker-for-coupon').daterangepicker(couponOptions, function(start, end, label) {
            $('#fromDate').val(start.format('YYYY-MM-DD'));
            $('#toDate').val(end.format('YYYY-MM-DD'));
        });

        // Date range value clear
        $('#daterangepicker-for-coupon').val("");
        $('#daterangepicker-for-coupon').on('cancel.daterangepicker', function(ev, picker) {
            $('#daterangepicker-for-coupon').val("");
            $('#fromDate').val('');
            $('#toDate').val('');
        });
    });

    </script>
@endpush
