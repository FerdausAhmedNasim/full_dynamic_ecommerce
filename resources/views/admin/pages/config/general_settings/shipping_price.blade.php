@extends('admin.pages.config.general_settings.layout.master')
@section('title', 'Shipping Cost')
@section('shipping-cost', 'active')

@section('settingsContent')
<div class="section-title mb-4 bar-before-title fw-bold">Shipping Cost</div>
<form method="post" action="{{ route('admin.config.general_settings.shipping_cost.update') }}"
    enctype="multipart/form-data">
    @csrf
    <div class="row p-3">
        <div class="col-md-12">
            <div class="form-group row @error('inside_dhaka') error @enderror">
                <label class="col-sm-2 required col-form-label ">{{ __('Inside Dhaka') }}</label>
                <div class="col-sm-7">
                    <div class="input-group mb-4">
                        <input required type="number" name="inside_dhaka" value="{{ old('inside_dhaka') ?? settings('inside_dhaka') }}" class="form-control"
                            placeholder="{{ __('Enter Amount') }}">
                    </div>
                    @error('inside_dhaka')
                    <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-group row @error('outside_dhaka') error @enderror">
                <label class="col-sm-2 required col-form-label ">{{ __('Outside Dhaka') }}</label>
                <div class="col-sm-7">
                    <div class="input-group mb-4">
                        <input required type="number" name="outside_dhaka" value="{{ old('outside_dhaka') ?? settings('outside_dhaka') }}" class="form-control"
                            placeholder="{{ __('Enter Amount') }}">
                    </div>
                    @error('outside_dhaka')
                    <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- @if(\App\Library\Helper::hasAuthRolePermission('social_link_update')) --}}
    <div class="row mt-2">
        <div class="modal-footer justify-content-center col-md-12">
            {!! \App\Library\Html::btnReset() !!}
            {!! \App\Library\Html::btnSubmit() !!}
        </div>
    </div>
    {{-- @endif --}}

</form>
@stop

@push('scripts')

@endpush