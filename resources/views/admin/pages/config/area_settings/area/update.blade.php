@extends('admin.pages.config.area_settings.layout.master')

@section('title', 'Update Area')
@section('area', 'active')

@section('areaSettingsContent')

    <div class="content-header d-flex justify-content-start">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update Area')) }}</h4>
        </div>
    </div>
    <hr>

    <form method="post" action="{{ route('admin.area.settings.area.update', $area->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="p-sm-3">

            <div class="form-group row @error('division_id') error @enderror">
                <label class="col-sm-3 col-form-label required" for="name">{{ __('Division') }}</label>
                <div class="col-sm-9">
                    <select class="form-control" name="division_id" id="division_id" style="width: 100%;" required>
                        <option value="" selected disabled>Select One</option>
                        @foreach($divisions as $division)
                            <option value="{{ $division->id }}" {{ old('division_id', $area?->thana?->district?->division?->id) == $division->id ? 'selected' : '' }}> {{ $division->en_name }}</option>
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
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}" {{ old('district_id', $area?->thana?->district?->id) == $district->id ? 'selected' : '' }}> {{ $district->en_name }}</option>
                        @endforeach
                    </select>
                    @error('district_id')
                    <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-group row @error('thana_id') error @enderror">
                <label class="col-sm-3 col-form-label required"
                    for="name">{{ __('Thana') }}</label>
                <div class="col-sm-9">
                    <select class="form-control" name="thana_id" id="thana_id" required>
                        @foreach($thanas as $thana)
                            <option value="{{ $thana->id }}" {{ old('thana_id', $area->thana_id) == $thana->id ? 'selected' : '' }}> {{ $thana->en_name }}</option>
                        @endforeach
                    </select>
                    @error('thana_id')
                    <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-group row @error('en_name') error @enderror">
                <label class="col-sm-3 col-form-label required">{{ __('Area') }}</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="en_name" value="{{ old('en_name', $area->en_name) }}" placeholder="{{ __('Thana Name') }}" required>
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
    @vite('resources/admin_assets/js/pages/areaSettings/area/create.js')
@endpush
