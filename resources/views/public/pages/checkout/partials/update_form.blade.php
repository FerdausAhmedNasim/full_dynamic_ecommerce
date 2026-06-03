@php
    $divisions = App\Models\Division::active()->get();
    $districts = App\Models\District::where('division_id', $address?->thana?->district->division_id)
        ->active()
        ->get();
    $thanas = App\Models\Thana::where('district_id', $address?->thana?->district_id)
        ->active()
        ->get();
    $areas = App\Models\Area::where('thana_id', $address?->thana?->id)
        ->active()
        ->get();
@endphp
<form method="POST" action="{{ route('dashboard.address.update', $address->id) }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12 mb-4">
            <div class="form-floating theme-form-floating form-group @error('street_address') error @enderror">
                <input type="text" name="street_address" class="form-control" id="updateStreetAddress"
                    value="{{ old('street_address', $address->street_address) }}"
                    placeholder="{{ __('Street Name & Number ') }}">
                <label for="updateStreetAddress">Street Name & Number -- update</label>
            </div>
            @error('street_address')
                <p class="m-0 text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="col-xxl-6 mb-4">
            <div class="form-floating theme-form-floating form-group @error('division_id') error @enderror">
                <select class="form-control" name="division_id" id="updateDivisionId" required>
                    <option value="" disabled selected="">Choose Your Division</option>
                    @foreach ($divisions as $division)
                        <option value="{{ $division->id }}"
                            {{ old('division_id', $address->thana->district->division->id) == $division->id ? 'selected' : '' }}>
                            {{ $division->en_name }}
                        </option>
                    @endforeach
                </select>
                <label for="updateDivisionId">Division</label>
            </div>
            @error('division_id')
                <p class="m-0 text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="col-xxl-6 mb-4">
            <div class="form-floating theme-form-floating form-group @error('district_id') error @enderror">
                <select class="form-control" name="district_id" id="updateDistrictId" required>
                    <option value="" disabled selected="">Choose Your District</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}"
                            {{ old('district_id', $address->thana->district->id) == $district->id ? 'selected' : '' }}>
                            {{ $district->en_name }}
                        </option>
                    @endforeach
                </select>
                <label for="updateDistrictId">District</label>
            </div>
            @error('district_id')
                <p class="m-0 text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="col-xxl-6 mb-4">
            <div class="form-floating theme-form-floating form-group @error('thana_id') error @enderror">
                <select class="form-control" name="thana_id" id="updateThanaId" required>
                    <option value="" disabled selected="">Choose Your Thana</option>
                    @foreach ($thanas as $thana)
                        <option value="{{ $thana->id }}"
                            {{ old('thana_id', $address->thana_id) == $thana->id ? 'selected' : '' }}>
                            {{ $thana->en_name }}
                        </option>
                    @endforeach
                </select>
                <label for="updateThanaId">Thana</label>
            </div>
            @error('thana_id')
                <p class="m-0 text-danger">{{ $message }}</p>
            @enderror
        </div>

        <!-- <div class="col-xxl-6 mb-4">
                    <div class="form-floating theme-form-floating form-group @error('area_text') error @enderror">
                        <input type="text" name="area_text" class="form-control" id="area_text"
                            value="{{ old('area_text', $address->area_text) }}" placeholder="{{ __('Your area_text') }}"
                            required>
                        <label for="area_text">Area</label>
                    </div>
                    @error('area_text')
    <p class="m-0 text-danger">{{ $message }}</p>
@enderror
                </div> -->

        <div class="col-xxl-6 mb-4">
            <div class="form-floating theme-form-floating form-group @error('area_id') error @enderror">
                <select class="form-control" name="area_id" id="updateAreaId">
                    <option value="" disabled selected="">Choose Your Area</option>
                    @foreach ($areas as $area)
                        <option value="{{ $area->id }}"
                            {{ old('area_id', $address->area_id) == $area->id ? 'selected' : '' }}>
                            {{ $area->en_name }}
                        </option>
                    @endforeach
                </select>
                <label for="updateAreaId">Area</label>
            </div>
            @error('area_id')
                <p class="m-0 text-danger">{{ $message }}</p>
            @enderror
        </div>


        {{-- <div class="col-sm-6 mb-4">
            <div class="form-floating theme-form-floating form-group @error('latitude') error @enderror">
                <input type="number" class="form-control" name="latitude" id="updateLatitude"
                    value="{{ old('latitude', $address->latitude) }}" step="0.00001"
                    placeholder="{{ __('Latitude (optional)') }}">
                <label for="updateLatitude">Latitude (optional)</label>
            </div>
        </div>

        <div class="col-sm-6 mb-4">
            <div class="form-floating theme-form-floating @error('longitude') error @enderror">
                <input type="number" class="form-control" name="longitude" id="updateLongitude"
                    value="{{ old('longitude', $address->longitude) }}" step="0.00001"
                    placeholder="{{ __('Longitude (optional)') }}">
                <label for="updateLongitude">Longitude (optional)</label>
            </div>
        </div> --}}
    </div>
    <button class="btn btn-md theme-bg-color text-white mt-3">Update Address</button>
</form>
@push('scripts')
    @vite('resources/frontend_assets/js/pages/checkout/updateAddress.js')
@endpush
