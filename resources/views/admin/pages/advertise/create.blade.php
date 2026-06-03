@extends('admin.layouts.master')

@section('title', __('New Ad'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.ad.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('New Ad')) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.ad.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-7">
                        <div class="p-sm-3">
                            <div class="form-group row @error('advertise_location_id') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Location') }}</label>
                                <div class="col-sm-9">
                                    <select id="advertise_location_id" class="form-control select2" name="advertise_location_id" required>
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($locations as $location)
                                            <option class="text-capitalize" value="{{ $location->id }}" data-name="{{ $location->location }}" {{ (old("advertise_location_id") == $location->id) ? "selected" : "" }}>
                                                {{ $location->location_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('advertise_location_id')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label required">{{ __('Ad Period') }}</label>
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

                            <div class="image-section">
                                <div class="form-group row @error('image') error @enderror">
                                    <label class="col-sm-3 col-form-label required">Ad Image</label>
                                    <div class="col-sm-9">
                                        <div class="file-upload-section">
                                            <input name="image" type="file"
                                                class="form-control d-none" allowed="png,gif,jpeg,jpg,webp">
                                            <div class="input-group col-xs-12">
                                                <input type="text" class="form-control file-upload-info"
                                                    disabled="" readonly
                                                    placeholder="Size: For Top Brand (785x350), For Deals (530x500) & max 512KB">
                                                <span class="input-group-append">
                                                    <button
                                                        class="file-upload-browse btn btn-outline-secondary"
                                                        type="button"><i class="fas fa-upload"></i>
                                                        Browse</button>
                                                </span>
                                            </div>
                                            @error('image')
                                                <p class="error-message">{{ $message }}</p>
                                            @enderror
                                            <div class="display-input-image d-none">
                                                <img src="{{ Vite::asset(\App\Library\Enum::NO_IMAGE_PATH) }}"
                                                    alt="Preview Image" />
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger file-upload-remove ml-3"
                                                    title="Remove">x</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row @error('link') error @enderror">
                                    <label class="col-sm-3 col-form-label required">{{ __('Link') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="link"
                                            value="{{ old('link') }}" placeholder="{{ __('Link') }}">
                                        @error('link')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-none flash-sale-product form-group row @error('product_ids') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Product') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control productSelect2" name="product_ids[]" multiple>
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($products as $product)
                                            <option class="text-capitalize" value="{{ $product->id }}"
                                                data-thumbnail="{{ $product->thumbnail }}"
                                            >
                                                {{ $product->getTranslation('title') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_ids')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
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


        $('#advertise_location_id').change(function() {
            var selectedLocationName = $(this).find(':selected').data('name');
            if (selectedLocationName == 'flash_sale' || selectedLocationName == 'top_sale') {
                $('.flash-sale-product').removeClass('d-none');
                $('.image-section').addClass('d-none');
            } else {
                $('.flash-sale-product').addClass('d-none');
                $('.image-section').removeClass('d-none');
            }
        });
    });
</script>
@endpush
