@extends('admin.pages.config.area_settings.layout.master')

@section('title', 'Update Thana')
@section('thana', 'active')

@section('areaSettingsContent')

    <div class="content-header d-flex justify-content-start">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update Thana')) }}</h4>
        </div>
    </div>
    <hr>

    <form method="post" action="{{ route('admin.area.settings.thana.update', $thana->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="p-sm-3">
            
            <div class="form-group row @error('division_id') error @enderror">
                <label class="col-sm-3 col-form-label required" for="name">{{ __('Division') }}</label>
                <div class="col-sm-9">
                    <select class="form-control" name="division_id" id="division_id" style="width: 100%;" required>
                        <option value="" selected disabled>Select One</option>
                        @foreach($divisions as $division)
                            <option value="{{ $division->id }}" {{ old('division_id', $thana?->district?->division_id) == $division->id ? 'selected' : '' }}> {{ $division->en_name }}</option>
                        @endforeach
                    </select>
                    @error('division_id')
                    <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-group row @error('district_id') error @enderror">
                <label class="col-sm-3 col-form-label required" for="name">{{ __('District') }}</label>
                <div class="col-sm-9">
                    <select class="form-control" name="district_id" id="district_id" required>
                        <option value="" disabled selected="">Select One</option>
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}" {{ old('district_id', $thana?->district_id) == $district->id ? 'selected' : '' }}> {{ $district->en_name }}</option>
                        @endforeach
                    </select>
                    @error('district_id')
                    <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-group row @error('en_name') error @enderror">
                <label class="col-sm-3 col-form-label required">{{ __('Thana') }}</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="en_name" value="{{ old('en_name', $thana->en_name) }}" placeholder="{{ __('Thana Name') }}" required>
                    @error('en_name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
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

@stop

@include('admin.assets.select2')

@push('scripts')
    @vite('resources/admin_assets/js/pages/areaSettings/thana/create.js')
@endpush
