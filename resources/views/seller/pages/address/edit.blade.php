<div class="card">
    <div class="card-body">

        <form method="post"
            action="{{ $address ? route('seller.address.update', $address->id) : route('seller.address.create', $user->id) }}"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <span class="text-center card-title"> Address Edit</span>
                    <div class="row pt-3">
                        <div class="col-md-6 px-3">
                            <div class="form-group row @error('street_address') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Street Address') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" name="street_address" class="form-control" id="homeStreetAddress"
                                        value="{{ old('street_address', $address->street_address) }}"
                                        placeholder="{{ __('Street Name & Number ') }}" required>
                                    @error('street_address')
                                    <p class="m-0 text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-6 px-3">
                            <div class="form-group row @error('division_id') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Division') }}</label>
                                <div class="col-sm-9">
                                    <select class="select form-control" name="division_id" id="division_id" required>
                                        <option value="" disabled selected="">Choose Your Division</option>
                                        @foreach($divisions as $division)
                                        <option value="{{ $division->id }}"
                                            {{ old('division_id', $address->area->division_id) == $division->id ? 'selected' : '' }}>
                                            {{ $division->en_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('division_id')
                                    <p class="m-0 text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-6 px-3">
                            <div class="form-group row @error('district_id') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('District') }}</label>
                                <div class="col-sm-9">
                                    <select class="select form-control" name="district_id" id="district_id" required>
                                        <option value="" disabled selected="">Choose Your District</option>
                                        @foreach($districts as $district)
                                        <option value="{{ $district->id }}"
                                            {{ old('district_id', $address->area->district_id) == $district->id ? 'selected' : '' }}>
                                            {{ $district->en_name }}
                                        </option>
                                        @endforeach
                                    </select>

                                    @error('district_id')
                                    <p class="m-0 text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-6 px-3">
                            <div class="form-group row @error('thana_id') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Thana') }}</label>
                                <div class="col-sm-9">
                                    <select class="select form-control" name="thana_id" id="thana_id" required>
                                        <option value="" disabled selected="">Choose Your Thana</option>
                                        @foreach($thanas as $thana)
                                        <option value="{{ $thana->id }}"
                                            {{ old('thana_id', $address->area->thana_id) == $thana->id ? 'selected' : '' }}>
                                            {{ $thana->en_name }}
                                        </option>
                                        @endforeach
                                    </select>

                                    @error('thana_id')
                                    <p class="m-0 text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-6 px-3">
                            <div class="form-group row @error('thana_id') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Area') }}</label>
                                <div class="col-sm-9">
                                    <select class="select form-control" name="area_id" id="area_id" required>
                                        <option value="" disabled selected="">Choose Your Area</option>
                                        @foreach($areas as $area)
                                        <option value="{{ $area->id }}"
                                            {{ old('area_id', $address->area_id) == $area->id ? 'selected' : '' }}>
                                            {{ $area->en_name }}
                                        </option>
                                        @endforeach
                                    </select>

                                    @error('area_id')
                                    <p class="m-0 text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 px-3">
                            <div class="form-group row @error('latitude') error @enderror">
                                <label class="col-sm-3 col-form-label">{{ __('Latitude') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="latitude" id="homeLatitude"
                                        value="{{ old('latitude', $address->latitude) }}" step="0.00001"
                                        placeholder="{{ __('Latitude (optional)') }}">

                                    @error('latitude')
                                    <p class="m-0 text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 px-3">
                            <div class="form-group row @error('longitude') error @enderror">
                                <label class="col-sm-3 col-form-label">{{ __('Longitude') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="longitude" id="homeLoggitude"
                                        value="{{ old('longitude', $address->longitude) }}" step="0.00001"
                                        placeholder="{{ __('Longitude (optional)') }}">

                                    @error('longitude')
                                    <p class="m-0 text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
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

@push('scripts')
@vite('resources/admin_assets/js/pages/user/employee/create.js')
{{-- @vite('resources/admin_assets/js/pages/address/autofill.js') --}}
@endpush