@extends('seller.layouts.master')

@section('title', __('New Bank Account'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('seller.coupon.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('New Bank Account')) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('seller.bankAccount.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-sm-3">
                            <div class="form-group row @error('bank_name') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Bank Name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="bank_name"
                                        value="{{ old('bank_name') }}" placeholder="{{ __('Bank Name') }}" required>
                                    @error('bank_name')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('branch_name') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Branch Name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="branch_name"
                                        value="{{ old('branch_name') }}" placeholder="{{ __('Branch Name') }}" required>
                                    @error('branch_name')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('account_name') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Account Name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="account_name"
                                        value="{{ old('account_name') }}" placeholder="{{ __('Account Name') }}" required>
                                    @error('account_name')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('account_number') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Account Number') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="account_number"
                                        value="{{ old('account_number') }}" placeholder="{{ __('Account Number') }}" required>
                                    @error('account_number')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="form-group row @error('routing_number') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Routing Number') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="routing_number"
                                        value="{{ old('routing_number') }}" placeholder="{{ __('Routing Number') }}" required>
                                    @error('routing_number')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div> --}}
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
