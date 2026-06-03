@extends('admin.pages.config.general_settings.layout.master')

@section('title', 'Invoice Settings')

@section('settingsContent')

    <form method="post" action="{{ route('admin.config.general_settings.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="p-sm-3">

                    <div class="form-group row @error('invoice_prefix') error @enderror">
                        <label class="col-sm-3 col-form-label" for="name">{{ __('Order Invoice Prefix') }}</label>
                        <div class="col-sm-9">

                            <input class="form-control" name="invoice_prefix" value="{{ old('invoice_prefix', settings('invoice_prefix')) }}" placeholder="{{ __('Order Invoice Prefix') }}">
                            @error('invoice_prefix')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('return_invoice_prefix') error @enderror">
                        <label class="col-sm-3 col-form-label" for="name">{{ __('Return Invoice Prefix') }}</label>
                        <div class="col-sm-9">

                            <input class="form-control" name="return_invoice_prefix" value="{{ old('return_invoice_prefix', settings('return_invoice_prefix')) }}" placeholder="{{ __('Return Invoice Prefix') }}">
                            @error('return_invoice_prefix')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('invoice_start_from') error @enderror">
                        <label class="col-sm-3 col-form-label" for="name">{{ __('Order Invoice Start From') }}</label>
                        <div class="col-sm-9">

                            <input type="number" min="0" class="form-control" name="invoice_start_from"
                            value="{{ old('invoice_start_from', settings('invoice_start_from')) }}" placeholder="{{ __('Invoice Start From') }}">
                            @error('invoice_start_from')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('return_invoice_start_from') error @enderror">
                        <label class="col-sm-3 col-form-label" for="name">{{ __('Return Invoice Start From') }}</label>
                        <div class="col-sm-9">

                            <input type="number" min="0" class="form-control" name="return_invoice_start_from"
                            value="{{ old('return_invoice_start_from', settings('return_invoice_start_from')) }}" placeholder="{{ __('Invoice Start From') }}">
                            @error('return_invoice_start_from')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('sku_prefix') error @enderror">
                        <label class="col-sm-3 col-form-label" for="name">{{ __('SKU Prefix') }}</label>
                        <div class="col-sm-9">

                            <input class="form-control" name="sku_prefix" value="{{ old('sku_prefix', settings('sku_prefix')) }}" placeholder="{{ __('SKU Prefix') }}">
                            @error('sku_prefix')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('barcode_prefix') error @enderror">
                        <label class="col-sm-3 col-form-label" for="name">{{ __('Barcode Prefix') }}</label>
                        <div class="col-sm-9">

                            <input class="form-control" name="barcode_prefix" value="{{ old('barcode_prefix', settings('barcode_prefix')) }}" placeholder="{{ __('Barcode Prefix') }}">
                            @error('barcode_prefix')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('low_stock_alert') error @enderror">
                        <label class="col-sm-3 col-form-label" for="name">{{ __('Low Stock Alert') }}</label>
                        <div class="col-sm-9">

                            <input class="form-control" name="low_stock_alert" value="{{ old('low_stock_alert', settings('low_stock_alert')) }}" placeholder="{{ __('Low Stock Alert') }}">
                            @error('low_stock_alert')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- <div class="form-group row @error('vat_amount') error @enderror">
                        <label class="col-sm-3 col-form-label" for="name">{{ __('Vat Amount (%)') }}</label>
                        <div class="col-sm-9">

                            <input type="number" step="0.01" class="form-control" name="vat_amount" value="{{ old('vat_amount', settings('vat_amount')) }}" placeholder="{{ __('Vat Amount (%)') }}">
                            @error('vat_amount')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div> --}}

                    <div class="form-group row @error('notification_time') error @enderror">
                        <label class="col-sm-3 col-form-label" for="name">{{ __('Notification Time') }}</label>
                        <div class="col-sm-9">

                            <input class="form-control" name="notification_time" value="{{ old('notification_time', settings('notification_time')) }}" placeholder="{{ __('Currency symbol') }}">
                            @error('notification_time')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="align-item-baseline form-group row @error('invoice_logo') error @enderror">
                        <label class="col-sm-3 col-form-label">Invoice Logo</label>
                        <div class="col-sm-9">
                            <div class="file-upload-section row align-item-baseline">
                                <div class="col-md-9">
                                    <input name="invoice_logo" type="file" class="form-control d-none"
                                        allowed="png,gif,jpeg,jpg">
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info" disabled=""
                                            readonly placeholder="Size: 300x50 and max 500kB">
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-outline-secondary"
                                                type="button"><i class="fas fa-upload"></i> Browse</button>
                                        </span>
                                    </div>
                                    @error('invoice_logo')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="display-input-image col-md-3">
                                    <img src="{{ settings('invoice_logo') ? asset(settings('invoice_logo')) : Vite::asset(\App\Library\Enum::NO_IMAGE_PATH) }}"
                                        alt="Preview Image" />
                                    <button type="button"
                                        class="btn btn-sm btn-outline-danger file-upload-remove ml-3"
                                        title="Remove">x</button>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        @if(\App\Library\Helper::hasAuthRolePermission('general_settings_update'))
        <div class="row mt-2">
            <div class="modal-footer justify-content-center col-md-12">
                {!! \App\Library\Html::btnReset() !!}
                {!! \App\Library\Html::btnSubmit() !!}
            </div>
        </div>
        @endif
        
    </form>

@endsection
