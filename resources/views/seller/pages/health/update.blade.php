@extends('seller.layouts.master')

@section('title', __('Update Health'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack( route('seller.profile.index') . '#health') !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update Health')) }}</h4>
        </div>
    </div>
    
    <div class="card shadow-sm col-xxl-6 col-xl-6 col-lg-12 col-md-12">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('seller.health.update', $health->id) }}"
                enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <div class="col-md-12">
                        <div class="p-sm-3">

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label required">{{ __('Vaccination Status') }}</label>
                                <div class="col-sm-9">
                                    <div class="d-inline-flex justify-content-start">
                                        <div class="form-check form-check-success mr-5">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="vaccination_status" value="Yes" required {{ old('vaccination_status', $health->vaccination_status) == "Yes" ? 'checked' : '' }}>
                                                Yes
                                                <i class="input-helper"></i></label>
                                        </div>
                                        <div class="form-check form-check-danger">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="vaccination_status" value="No" required {{ old('vaccination_status', $health->vaccination_status) != "Yes" ? 'checked' : '' }}>
                                                No
                                                <i class="input-helper"></i></label>
                                        </div>
                                    </div>

                                    @error('vaccination_status')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('gp_name') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('GP Name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="gp_name"
                                        value="{{ old('gp_name', $health->gp_name) }}"
                                        placeholder="{{ __('GP Name') }}" required>
                                    @error('gp_name')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('blood_group') error @enderror">
                                <label class="col-sm-3 col-form-label">{{ __('Blood Group') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="blood_group" required>
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach(\App\Library\Enum::getBloodGroup() as $index => $value)
                                            <option class="text-capitalize" value="{{ $index }}" {{(old("blood_group", $health->blood_group) == $index) ? "selected" : ""}}>
                                                {{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('blood_group')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror

                                </div>
                            </div>

                            <div class="form-group row @error('medical_practice') error @enderror">
                                <label class="col-sm-3 col-form-label">{{ __('Medical Practice') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="medical_practice" value="{{ old('medical_practice', $health->medical_practice) }}"
                                        placeholder="{{ __('Medical Practice') }}">
                                    @error('medical_practice')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('disablity_status') error @enderror">
                                <label class="col-sm-3 col-form-label ">{{ __('Disability Status') }} </label>
                                <div class="col-sm-9">
                                    <div class="d-inline-flex justify-content-start">
                                        <div class="form-check form-check-success">
                                            <label class="form-check-label">
                                            <input type="hidden" value="0" name="disablity_status">
                                            <input type="checkbox" class="form-check-input" name="disablity_status" value="{{ old('disablity_status' == 1 ? 'checked' : '', 1) }}" {{ $health->disablity_status == 1 ? 'checked' : '' }}>
                                            <i class="input-helper"></i></label>
                                        </div>
                                        @error('disablity_status')
                                        <p class="error-message text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer justify-content-center">
                    {!! \App\Library\Html::btnSubmit() !!}
                </div>

            </form>
        </div>
    </div>
</div>
@stop
