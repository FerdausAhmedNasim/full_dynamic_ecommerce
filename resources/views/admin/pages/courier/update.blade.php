@extends('admin.layouts.master')

@section('title', __('Update Pricing Plans'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.courier_pricing_plan.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update Pricing Plans')) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm col-md-8">
        <div class="card-body py-sm-4">

            <form method="post" action="{{ route('admin.courier_pricing_plan.update', $courierPricingPlan->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="p-sm-3">

                    <div class="form-group row @error('pickup_location') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('Pickup Location') }}</label>
                        <div class="col-sm-9">
                            <select class="select form-control" name="pickup_location" id="pickup_location" style="width: 100%;" required>
                                <option value="" selected disabled>Select One</option>
                                @foreach(\App\Library\Enum::getCourierPickupAndDeliveryLocation() as $key => $pickupLocation)
                                    <option value="{{ $key }}" {{ old('pickup_location', $courierPricingPlan->pickup_location) == $key ? 'selected' : '' }}> {{ $pickupLocation }}</option>
                                @endforeach
                            </select>
                            @error('pickup_location')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('delivery_location') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('Delivery Location') }}</label>
                        <div class="col-sm-9">
                            <select class="select form-control" name="delivery_location" id="delivery_location" style="width: 100%;" required>
                                <option value="" selected disabled>Select One</option>
                                @foreach(\App\Library\Enum::getCourierPickupAndDeliveryLocation() as $key => $deliveryLocation)
                                    <option value="{{ $key }}" {{ old('delivery_location', $courierPricingPlan->delivery_location) == $key ? 'selected' : '' }}> {{ $deliveryLocation }}</option>
                                @endforeach
                            </select>
                            @error('delivery_location')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('min_weight') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('Minimum Weight') }}</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="min_weight" id="min_weight" step="any" min="0" max="{{ settings('extra_charge_after_weight') }}"
                                value="{{ old('min_weight', $courierPricingPlan->min_weight) }}" placeholder="{{ __('Minimum Weight') }}" required>
                            @error('min_weight')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('max_weight') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('Maximum Weight') }}</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="max_weight" id="max_weight" step="any" min="0" max="{{ settings('extra_charge_after_weight') }}"
                                value="{{ old('max_weight', $courierPricingPlan->max_weight) }}" placeholder="{{ __('Maximum Weight') }}" required>
                            @error('max_weight')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('price') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('Price') }}</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="price" id="price" step="0.01" min="0"
                                value="{{ old('price', $courierPricingPlan->price) }}" placeholder="{{ __('Price') }}" required>
                            @error('price')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <input type="hidden" id="maxValue" value="{{ settings('extra_charge_after_weight') }}">

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

@push('scripts')
    @vite('resources/admin_assets/js/pages/courier/create.js')
@endpush
