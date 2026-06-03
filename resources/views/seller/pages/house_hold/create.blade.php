@extends('seller.layouts.master')

@section('title', __('New Household'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack( route('seller.profile.index') . '#house-hold') !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('New Household')) }}</h4>
        </div>

    </div>

    <div class="card shadow-sm">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('seller.house_hold.create') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12">
                        <div class="p-sm-3">

                            <div class="form-group row @error('number_of_member') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Num Of Member') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="number_of_member"
                                        value="{{ old('number_of_member') }}" placeholder="{{ __('Ex: 10') }}"
                                        required>
                                    @error('number_of_member')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('person_18_and_over') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Num Of Person 18+') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="person_18_and_over"
                                        value="{{ old('person_18_and_over') }}" placeholder="{{ __('Ex: 10') }}"
                                        required>
                                    @error('person_18_and_over')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('person_under_18') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Num Of Under 18') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="person_under_18"
                                        value="{{ old('person_under_18') }}" placeholder="{{ __('Ex: 10') }}"
                                        required>
                                    @error('person_under_18')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('primary_language') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Primary Language') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="primary_language"
                                        value="{{ old('primary_language') }}" placeholder="{{ __('Enter Language') }}"
                                        required>
                                    @error('primary_language')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('secondary_language') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Secondary Language') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="secondary_language"
                                        value="{{ old('secondary_language') }}" placeholder="{{ __('Enter Language') }}"
                                        required>
                                    @error('secondary_language')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('third_language') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Third Language') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="third_language"
                                        value="{{ old('third_language') }}" placeholder="{{ __('Enter Language') }}"
                                        required>
                                    @error('third_language')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12">

                    <div class="form-group row">
                                <label class="col-sm-3 col-form-label required">{{ __('Healthy Home Initiative') }}</label>
                                <div class="col-sm-9">
                                    <div class="d-inline-flex justify-content-start">
                                        <div class="form-check form-check-info mr-5">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="healthy_home_initiative" value="1" required {{ old('healthy_home_initiative') ? 'checked' : '' }}>
                                                Yes
                                                <i class="input-helper"></i></label>
                                        </div>
                                        <div class="form-check form-check-danger">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="healthy_home_initiative" value="0" required {{ !old('healthy_home_initiative') ? 'checked' : '' }}>
                                                No
                                                <i class="input-helper"></i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label required">{{ __('Smoker Status') }}</label>
                                <div class="col-sm-9">
                                    <div class="d-inline-flex justify-content-start">
                                        <div class="form-check form-check-info mr-5">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="smoker_status" value="1" required {{ old('smoker_status') ? 'checked' : '' }}>
                                                Yes
                                                <i class="input-helper"></i></label>
                                        </div>
                                        <div class="form-check form-check-danger">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="smoker_status" value="0" required {{ !old('smoker_status') ? 'checked' : '' }}>
                                                No
                                                <i class="input-helper"></i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label required">{{ __('Pet In House') }}</label>
                                <div class="col-sm-9">
                                    <div class="d-inline-flex justify-content-start">
                                        <div class="form-check form-check-info mr-5">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="pet_in_house" value="1" required {{ old('pet_in_house') ? 'checked' : '' }}>
                                                Yes
                                                <i class="input-helper"></i></label>
                                        </div>
                                        <div class="form-check form-check-danger">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="pet_in_house" value="0" required {{ !old('pet_in_house') ? 'checked' : '' }}>
                                                No
                                                <i class="input-helper"></i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row @error('number_of_pets') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Number Of Pet') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="number_of_pets"
                                        value="{{ old('number_of_pets') }}" placeholder="{{ __('Ex: 10') }}"
                                        required>
                                    @error('number_of_pets')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('type_of_pet') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Type Of Pet') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="type_of_pet"
                                        value="{{ old('type_of_pet') }}" placeholder="{{ __('Type Of Pet') }}"
                                        required>
                                    @error('type_of_pet')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
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

@push('scripts')

@endpush
