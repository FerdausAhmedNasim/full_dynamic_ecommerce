@php 
$divisions = App\Models\Division::active()->get();
@endphp
<form method="POST" action="{{ route('dashboard.address.create') }}" enctype="multipart/form-data"
    class="client-signup-form">
    @csrf
    <div class="row">
        <div class="col-12 mb-4">
            <div class="form-floating theme-form-floating form-group @error('street_address') error @enderror">
                <input type="text" name="street_address" class="form-control" id="street_address"
                    value="{{ old('street_address') }}" placeholder="{{ __('Street Name & Number ') }}">
                <label for="street_address">Street Name & Number</label>
            </div>
            @error('street_address')
            <p class="m-0 text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="col-xxl-6 mb-4">
            <div class="form-floating theme-form-floating form-group @error('division_id') error @enderror">
                <select class="form-control" name="division_id" id="division_id" required>
                    <option value="" disabled selected="">Choose Your Division</option>
                    @foreach($divisions as $division)
                    <option value="{{ $division->id }}" {{ old('division_id') == $division->id ? 'selected' : '' }}>
                        {{ $division->en_name }}
                    </option>
                    @endforeach
                </select>
                <label for="division_id">Division</label>
            </div>
            @error('division_id')
            <p class="m-0 text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="col-xxl-6 mb-4">
            <div class="form-floating theme-form-floating form-group @error('district_id') error @enderror">
                <select class="form-control" name="district_id" id="district_id" required>
                    <option value="" disabled selected="">Choose Your District</option>

                </select>
                <label for="district_id">District</label>
            </div>
            @error('district_id')
            <p class="m-0 text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="col-xxl-6 mb-4">
            <div class="form-floating theme-form-floating @error('thana_id') error @enderror">
                <select class="form-control" name="thana_id" id="thana_id" required>
                    <option value="" disabled selected="">Choose Your Thana</option>

                </select>
                <label for="thana_id">Thana</label>
            </div>
            @error('thana_id')
            <p class="m-0 text-danger">{{ $message }}</p>
            @enderror
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

        <div class="col-xxl-6 mb-4">
            <div class="form-floating theme-form-floating form-group @error('area_id') error @enderror">
                <select class="form-control" name="area_id" id="area_id">
                    <option value="" disabled selected="">Choose Your Area</option>

                </select>
                <label for="area_id">Area</label>
            </div>
            @error('area_id')
            <p class="m-0 text-danger">{{ $message }}</p>
            @enderror
        </div>


        {{-- <div class="col-sm-6 mb-4">
            <div class="form-floating theme-form-floating form-group @error('latitude') error @enderror">
                <input type="number" class="form-control" name="latitude" id="latitude" value="{{ old('latitude') }}"
                    step="0.00001" placeholder="{{ __('Latitude (optional)') }}">
                <label for="latitude">Latitude (optional)</label>
            </div>
        </div>

        <div class="col-sm-6 mb-4">
            <div class="form-floating theme-form-floating @error('longitude') error @enderror">
                <input type="number" class="form-control" name="longitude" id="longitude" value="{{ old('longitude') }}"
                    step="0.00001" placeholder="{{ __('Longitude (optional)') }}">
                <label for="longitude">Longitude (optional)</label>
            </div>
        </div> --}}
        <p style=" font-size: 16px">আপনার অর্ডারটি নিশ্চিত করতে নাম, মোবাইল নাম্বার, বিভাগ, জেলা, থানা সঠিকভাবে পূরণ করুন এবং অ্যাড বাটন এ ক্লিক করুন। প্রয়োজনে ফোন করুন 01575468540।</p>
    </div>
    <div class="d-flex justify-content-end">
        <button class="btn btn-md theme-bg-color text-white mt-3">Add</button>
    </div>
</form>
@push('scripts')
@vite('resources/frontend_assets/js/pages/address/create.js')
@endpush