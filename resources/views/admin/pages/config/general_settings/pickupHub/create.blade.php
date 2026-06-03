@extends('admin.pages.config.general_settings.layout.master')

@section('title', 'System Details')

@section('settingsContent')

    <form method="post" action="{{ route('admin.config.general_settings.pickup_hub.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="p-sm-3">

                    <div class="form-group row @error('division_id') error @enderror">
                        <label class="col-sm-3 col-form-label required" for="name">{{ __('Division') }}</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="division_id" id="division_id" style="width: 100%;" required>
                                <option value="" selected disabled>Select One</option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id }}" {{ old('division_id') == $division->id ? 'selected' : '' }}> {{ $division->en_name }}</option>
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
                                <option value="" disabled selected="">Choose Your District</option>
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
                                <option value="" disabled selected="">Choose Your Thana</option>
                            </select>
                            @error('thana_id')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('area_id') error @enderror">
                        <label class="col-sm-3 col-form-label required"
                            for="name">{{ __('Area') }}</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="area_id" id="area_id" required>
                                <option value="" disabled selected="">Choose Your Area</option>
                            </select>
                            @error('area_id')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('street_address') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('Street Address') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="street_address"
                                value="{{ old('street_address') }}" placeholder="{{ __('Street Address') }}" required>
                            @error('street_address')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('note') error @enderror">
                        <label class="col-sm-3 col-form-label"
                            for="name">{{ __('Note') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="note" class="form-control"
                                placeholder="{{ __('Note') }}"
                                value="{{ old('note') }}">
                            @error('note')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('latitude') error @enderror">
                        <label class="col-sm-3 col-form-label"
                            for="name">{{ __('Latitude') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="latitude" class="form-control"
                                placeholder="{{ __('Latitude') }}"
                                value="{{ old('latitude') }}">
                            @error('latitude')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('longitude') error @enderror">
                        <label class="col-sm-3 col-form-label"
                            for="name">{{ __('Longitude') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="longitude" class="form-control"
                                placeholder="{{ __('Longitude') }}"
                                value="{{ old('longitude') }}">
                            @error('longitude')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="modal-footer justify-content-center col-md-12">
                {!! \App\Library\Html::btnReset() !!}
                {!! \App\Library\Html::btnSubmit() !!}
            </div>
        </div>
    </form>

@endsection


@push('scripts')
    @vite('resources/admin_assets/js/pages/config/pickupHub/create.js')
@endpush
