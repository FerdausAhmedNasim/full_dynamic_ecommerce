<form method="post" action="{{ route('seller.address.create', $user->id ) }}" enctype="multipart/form-data">
    @csrf
    @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div>{{$error}}</div>
                            @endforeach
                        @endif
    <div class="row">
        <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12">
            <div class="p-sm-3">

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label required">{{ __('Home Address') }}</label>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group @error('home_street_address') error @enderror">
                                    <input type="text" class="form-control"
                                        value="{{ old('home_street_address') }}"
                                        name="home_street_address"
                                        placeholder="{{ __('Street Name & Number ') }}" id="homeStreetAddress" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group @error('home_suburb') error @enderror">
                                    <input type="text" class="form-control" name="home_suburb"
                                        value="{{ old('home_suburb') }}" placeholder="{{ __('Suburb') }}"
                                        id="homeSubRoad">
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="form-group @error('home_city') error @enderror">
                                    <input type="text" class="form-control" name="home_city"
                                        value="{{ old('home_city') }}" id="homeCity"
                                        placeholder="{{ __('City') }}" required>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="form-group @error('home_post_code') error @enderror">
                                    <input type="number" class="form-control" name="home_post_code"
                                        id="homePostCode" value="{{ old('home_post_code') }}"
                                        placeholder="{{ __('Post Code') }}" required>
                                </div>
                            </div>

                            <div class="col-sm-6 mt-3">
                                <div class="form-group @error('home_latitude') error @enderror">
                                    <input type="number" class="form-control" name="home_latitude"
                                        id="homeLatitude" value="{{ old('home_latitude') }}" step="0.00001"
                                        placeholder="{{ __('Latitude (optional)') }}">
                                </div>
                            </div>

                            <div class="col-sm-6 mt-3">
                                <div class="form-group @error('home_longitude') error @enderror">
                                    <input type="number" class="form-control" name="home_longitude"
                                        id="homeLoggitude" value="{{ old('home_longitude') }}" step="0.00001"
                                        placeholder="{{ __('Longitude (optional)') }}">
                                </div>
                            </div>
                        </div>
                        @error('home_street_address')
                        <p class="error-message text-danger">{{ $message }}</p>
                        @enderror
                        @error('home_suburb')
                        <p class="error-message text-danger">{{ $message }}</p>
                        @enderror
                        @error('home_city')
                        <p class="error-message text-danger">{{ $message }}</p>
                        @enderror
                        @error('home_post_code')
                        <p class="error-message text-danger">{{ $message }}</p>
                        @enderror
                        @error('home_latitude')
                        <p class="error-message text-danger">{{ $message }}</p>
                        @enderror
                        @error('home_longitude')
                        <p class="error-message text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12">
            <div class="p-sm-3">
                <div class="form-group row">

                    <div class="col-sm-3">
                        <label class="col-form-label required">{{ __('Postal Address') }}</label><br>
                        Same as <input type="checkbox" id="sameAddress">
                    </div>

                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group @error('postal_street_address') error @enderror">
                                    <input type="text" class="form-control"
                                        value="{{ old('postal_street_address') }}"
                                        name="postal_street_address" id="postalStreetAddress"
                                        placeholder="{{ __('Street Name & Number') }}" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group @error('postal_suburb') error @enderror">
                                    <input type="text" class="form-control" name="postal_suburb"
                                        value="{{ old('postal_suburb') }}" id="postalSubRoad"
                                        placeholder="{{ __('Suburb') }}">
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="form-group @error('postal_city') error @enderror">
                                    <input type="text" class="form-control" name="postal_city"
                                        value="{{ old('postal_city') }}" id="postalCity"
                                        placeholder="{{ __('City') }}" required>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="form-group @error('postal_post_code') error @enderror">
                                    <input type="number" class="form-control" name="postal_post_code"
                                        id="postalPostCode" value="{{ old('postal_post_code') }}"
                                        placeholder="{{ __('Post Code') }}" required>
                                </div>
                            </div>

                            <div class="col-sm-6 mt-3">
                                <div class="form-group @error('postal_latitude') error @enderror">
                                    <input type="number" class="form-control" id="postalLatitude" step="0.00001"
                                        name="postal_latitude" value="{{ old('postal_latitude') }}"
                                        placeholder="{{ __('Latitude (optional)') }}">
                                </div>
                            </div>

                            <div class="col-sm-6 mt-3">
                                <div class="form-group @error('postal_longitude') error @enderror">
                                    <input type="number" class="form-control" id="postalLoggitude" step="0.00001"
                                        name="postal_longitude" value="{{ old('postal_longitude') }}"
                                        placeholder="{{ __('Longitude (optional)') }}">
                                </div>
                            </div>
                        </div>
                        @error('postal_street_address')
                        <p class="error-message text-danger">{{ $message }}</p>
                        @enderror
                        @error('postal_suburb')
                        <p class="error-message text-danger">{{ $message }}</p>
                        @enderror
                        @error('postal_city')
                        <p class="error-message text-danger">{{ $message }}</p>
                        @enderror
                        @error('postal_post_code')
                        <p class="error-message text-danger">{{ $message }}</p>
                        @enderror
                        @error('postal_latitude')
                        <p class="error-message text-danger">{{ $message }}</p>
                        @enderror
                        @error('postal_longitude')
                        <p class="error-message text-danger">{{ $message }}</p>
                        @enderror
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
@push('scripts')
@vite('resources/admin_assets/js/pages/address/autofill.js')
@endpush