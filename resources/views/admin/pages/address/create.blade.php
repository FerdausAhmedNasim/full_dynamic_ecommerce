<div class="p-sm-3">
    <div class="form-group row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-md-6 px-3">
                    <div class="form-group row @error('address.street_address') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('Street Name & Number ') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="address[street_address]" class="form-control"
                                id="homeStreetAddress" value="{{ old('address.street_address') }}"
                                placeholder="{{ __('Street Name & Number ') }}" required>

                            <span class="error-message text-danger" id="error-homeStreetAddress"></span>
                            @error('address.street_address')
                            <p class="m-0 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-xxl-6 px-3">
                    <div class="form-group row @error('address.division_id') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('Division') }}</label>
                        <div class="col-sm-9">
                            <select class="select form-control" name="address[division_id]" id="division_id" required>
                                <option value="" disabled selected="">Choose Your Division</option>
                                @foreach($divisions as $division)
                                <option value="{{ $division->id }}"
                                    {{ old('address.division_id') == $division->id ? 'selected' : '' }}>
                                    {{ $division->en_name }}
                                </option>
                                @endforeach
                            </select>
                            <span class="error-message text-danger" id="error-division_id"></span>
                            @error('address.division_id')
                            <p class="m-0 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-xxl-6 px-3">
                    <div class="form-group row @error('address.district_id') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('District') }}</label>
                        <div class="col-sm-9">
                            <select class="select form-control" name="address[district_id]" id="district_id" required>
                                <option value="" disabled selected="">Choose Your District</option>

                            </select>

                            <span class="error-message text-danger" id="error-district_id"></span>
                            @error('district_id')
                            <p class="m-0 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-xxl-6 px-3">
                    <div class="form-group row @error('address.thana_id') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('Thana') }}</label>
                        <div class="col-sm-9">
                            <select class="select form-control" name="address[thana_id]" id="thana_id" required>
                                <option value="" disabled selected="">Choose Your Thana</option>

                            </select>
                            <span class="error-message text-danger" id="error-thana_id"></span>
                            @error('address.thana_id')
                            <p class="m-0 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- <div class="col-xxl-6 mb-4">
                    <div class="form-floating theme-form-floating form-group @error('area_text') error @enderror">
                        <input type="text" name="area_text" class="form-control" id="area_text"
                            value="{{ old('area_text') }}" placeholder="{{ __('Your area_text') }}"
                            required>
                        <label for="area_text">Area</label>
                    </div>
                    @error('area_text')
                    <p class="m-0 text-danger">{{ $message }}</p>
                    @enderror
                </div> -->

                <div class="col-xxl-6 px-3">
                    <div class="form-group row @error('address.thana_id') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('Area') }}</label>
                        <div class="col-sm-9">
                            <select class="select form-control" name="address[area_id]" id="area_id" required>
                                <option value="" disabled selected="">Choose Your Area</option>

                            </select>
                            <span class="error-message text-danger" id="error-area_id"></span>
                            @error('address.area_id')
                            <p class="m-0 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 px-3">
                    <div class="form-group row @error('address.latitude') error @enderror">
                        <label class="col-sm-3 col-form-label">{{ __('Latitude') }}</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="address[latitude]" id="homeLatitude"
                                value="{{ old('address.latitude') }}" step="0.00001"
                                placeholder="{{ __('Latitude (optional)') }}">

                            @error('address.latitude')
                            <p class="m-0 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 px-3">
                    <div class="form-group row @error('address.longitude') error @enderror">
                        <label class="col-sm-3 col-form-label">{{ __('Longitude') }}</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="address[longitude]" id="homeLoggitude"
                                value="{{ old('address.longitude') }}" step="0.00001"
                                placeholder="{{ __('Longitude (optional)') }}">

                            @error('address.longitude')
                            <p class="m-0 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
@push('scripts')
@vite('resources/frontend_assets/js/pages/address/create.js')
@endpush