@extends('admin.pages.config.general_settings.layout.master')

@section('title', 'Courier')
@section('courier', 'active')

@section('settingsContent')

    <form method="post" action="{{ route('admin.config.general_settings.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="p-sm-3">

                    <input type="hidden" name="courier" value="courier">

                    <div class="form-group row @error('extra_charge_after_weight') error @enderror">
                        <label class="col-sm-5 required col-form-label ">{{ __('Extre Delivery Charge Will Apply After (...) KG') }}</label>
                        <div class="col-sm-7">
                            <div class="input-group mb-4">
                                <input required type="number" min="1" name="extra_charge_after_weight" value="{{ old('extra_charge_after_weight') ?? settings('extra_charge_after_weight') }}" class="form-control"
                                    placeholder="{{ __('Enter Weight in KG') }}">
                            </div>
                            @error('extra_charge_after_weight')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('extra_charge_for_inside_dhaka') error @enderror">
                        <label class="col-sm-5 required col-form-label ">{{ __('Inside Dhaka Extre Delivery Charge Per Kg Will Apply ') }}</label>
                        <div class="col-sm-7">
                            <div class="input-group mb-4">
                                <input required type="number" min="1" name="extra_charge_for_inside_dhaka" value="{{old('extra_charge_for_inside_dhaka') ?? settings('extra_charge_for_inside_dhaka') }}" class="form-control"
                                    placeholder="{{ __('Enter Extra Charge for Inside Dhaka') }}">
                            </div>
                            @error('extra_charge_for_inside_dhaka')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('extra_charge_for_outside_dhaka') error @enderror">
                        <label class="col-sm-5 required col-form-label ">{{ __('Outside Dhaka Extre Delivery Charge Per Kg Will Apply') }}</label>
                        <div class="col-sm-7">
                            <div class="input-group mb-4">
                                <input required type="number" min="1" name="extra_charge_for_outside_dhaka" value="{{old('extra_charge_for_outside_dhaka') ?? settings('extra_charge_for_outside_dhaka') }}" class="form-control"
                                    placeholder="{{ __('Enter Extra Charge for Outside Dhaka') }}">
                            </div>
                            @error('extra_charge_for_outside_dhaka')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('extra_charge_for_sub_dhaka') error @enderror">
                        <label class="col-sm-5 required col-form-label ">{{ __('Sub Dhaka Extre Delivery Charge Per Kg Will Apply') }}</label>
                        <div class="col-sm-7">
                            <div class="input-group mb-4">
                                <input required type="number" min="1" name="extra_charge_for_sub_dhaka" value="{{old('extra_charge_for_sub_dhaka') ?? settings('extra_charge_for_sub_dhaka') }}" class="form-control"
                                    placeholder="{{ __('Enter Extra Charge for Sub Dhaka') }}">
                            </div>
                            @error('extra_charge_for_sub_dhaka')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    @if (false)
                        <div class="form-group row @error('penalty_amount') error @enderror">
                            <label class="col-sm-5 required col-form-label ">{{ __('Penalty Charge') }}</label>
                            <div class="col-sm-7">
                                <div class="input-group mb-4">
                                    <input required type="number" min="1" name="penalty_amount" value="{{old('penalty_amount') ?? settings('penalty_amount') }}" class="form-control"
                                        placeholder="{{ __('Enter Extra Charge for Outside Dhaka') }}">
                                </div>
                                @error('penalty_amount')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @endif

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
