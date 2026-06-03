@extends('seller.layouts.master')

@section('title', __('Update profile'))

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.profile.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ __('Update Profile') }}</h4>
        </div>

    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="post" action="{{ route('seller.profile.update', $user->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-sm-3">

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label required">{{ __('Name') }}</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group @error('user.first_name') error @enderror">
                                                <input type="text" class="form-control"
                                                    value="{{ old('user.first_name', $user->first_name) }}" name="user[first_name]"
                                                    placeholder="{{ __('First Name') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group @error('user.m_name') error @enderror">
                                                <input type="text" class="form-control" name="user[m_name]"
                                                    value="{{ old('user.m_name', $user->m_name) }}"
                                                    placeholder="{{ __('Middle Name (optioanl)') }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group @error('user.last_name') error @enderror">
                                                <input type="text" class="form-control" name="user[last_name]"
                                                    value="{{ old('user.last_name', $user->last_name) }}"
                                                    placeholder="{{ __('Last Name') }}">
                                            </div>
                                        </div>
                                    </div>
                                    @error('user.first_name')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                    @error('user.m_name')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                    @error('user.last_name')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('user.email') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Email Address') }}</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="user[email]"
                                        value="{{ old('user.email', $user->email) }}"
                                        placeholder="{{ __('Email Address') }}" required>
                                    @error('user.email')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-6">

                        <div class="p-sm-3">

                            <div class="form-group row @error('user.dob') error @enderror">
                                <label class="col-sm-3 col-form-label required"
                                    for="name">{{ __('Date Of Birth') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" name="user[dob]" id="userDob" placeholder="{{ settings('date_format') }}"
                                        class="form-control datepicker-max-today" value="{{old('user.dob', $user->dob)}}" required>
                                    @error('user.dob')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('user.gender') error @enderror">
                                <label class="col-sm-3 col-form-label required" for="name">{{ __('Gender') }}</label>
                                <div class="col-sm-9">
                                    <select class="select form-control" name="user[gender]" id="userGender"
                                        style="width: 100%;" required>
                                        <option value="" selected disabled>Select One</option>
                                        @foreach($genders as $gender)
                                        <option value="{{ $gender }}"
                                            {{ old('user.gender', $user->gender) == $gender ? "selected" : "" }}>
                                            {{ $gender }}</option>
                                        @endforeach
                                    </select>
                                    @error('user.gender')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('user.phone') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Mobile No') }}</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-4">
                                        {{-- <div class="input-group-prepend">
                                            <select name="user[country_code]" class="input-group-text text-primary"
                                                required>
                                                @foreach($countries as $key => $country)
                                                <option value="{{ old('user.country_code', $country['code']) }}"
                                                    {{ ($country['code'] == ($user ? (explode('-', $user->phone))[0] : "+880")) ? "selected" : "" }}>
                                                    {{$key}} {{ $country['code']}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div> --}}
                                        @if ($user)
                                        <input type="number" name="user[phone]"
                                            value="{{ old('user.phone', ((strpos($user->phone, '-') == true) ? (explode('-', $user->phone))[1] : $user->phone) ) }}"
                                            class="form-control" placeholder="{{ __('013 355 666') }}" required>
                                        @else
                                        <input type="number" name="user[phone]" value="{{ old('user.phone') }}"
                                            class="form-control" placeholder="{{ __('013 355 666') }}" required>
                                        @endif

                                    </div>
                                    @error('user.phone')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="p-sm-3 col-sm-12">

                        <div class="row text-center">
                            <div class="col-md-6">
                                <span class="text-center card-title">Home Address</span>
                                <div class="p-sm-3">

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label required">{{ __('Home Address') }}</label>
                                        <div class="col-sm-9">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div
                                                        class="form-group @error('address.home_street_address') error @enderror">
                                                        <input type="text" class="form-control"
                                                            value="{{ old('address.home_street_address', $address?->home_street_address) }}"
                                                            name="address[home_street_address]"
                                                            placeholder="{{ __('Street Name & Number ') }}"
                                                            id="homeStreetAddress" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div
                                                        class="form-group @error('address.home_suburb') error @enderror">
                                                        <input type="text" class="form-control"
                                                            name="address[home_suburb]"
                                                            value="{{ old('address.home_suburb', $address?->home_suburb) }}"
                                                            placeholder="{{ __('Suburb') }}" id="homeSubRoad">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                    <div class="form-group @error('address.home_city') error @enderror">
                                                        <input type="text" class="form-control"
                                                            name="address[home_city]"
                                                            value="{{ old('address.home_city', $address?->home_city) }}" id="homeCity"
                                                            placeholder="{{ __('City') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                    <div
                                                        class="form-group @error('address.home_post_code') error @enderror">
                                                        <input type="number" class="form-control"
                                                            name="address[home_post_code]" id="homePostCode"
                                                            value="{{ old('address.home_post_code', $address?->home_post_code) }}"
                                                            placeholder="{{ __('Post Code') }}" required>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 mt-3">
                                                    <div
                                                        class="form-group @error('address.home_latitude') error @enderror">
                                                        <input type="text" class="form-control"
                                                            name="address[home_latitude]" id="homeLatitude"
                                                            value="{{ old('address.home_latitude', $address?->home_latitude) }}"
                                                            placeholder="{{ __('Latitude (optional)') }}">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 mt-3">
                                                    <div
                                                        class="form-group @error('address.home_longitude') error @enderror">
                                                        <input type="text" class="form-control"
                                                            name="address[home_longitude]" id="homeLoggitude"
                                                            value="{{ old('address.home_longitude', $address?->home_longitude) }}"
                                                            placeholder="{{ __('Longitude (optional)') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            @error('address.home_street_address')
                                            <p class="error-message text-danger">{{ $message }}</p>
                                            @enderror
                                            @error('address.home_suburb')
                                            <p class="error-message text-danger">{{ $message }}</p>
                                            @enderror
                                            @error('address.home_city')
                                            <p class="error-message text-danger">{{ $message }}</p>
                                            @enderror
                                            @error('address.home_post_code')
                                            <p class="error-message text-danger">{{ $message }}</p>
                                            @enderror
                                            @error('address.home_latitude')
                                            <p class="error-message text-danger">{{ $message }}</p>
                                            @enderror
                                            @error('address.home_longitude')
                                            <p class="error-message text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <span class="text-center card-title">Postal Address</span>
                                <div class="p-sm-3">
                                    <div class="form-group row">

                                        <div class="col-sm-3">
                                            <label
                                                class="col-form-label required">{{ __('Postal Address') }}</label><br>
                                            Same as <input type="checkbox" id="sameAddress">
                                        </div>

                                        <div class="col-sm-9">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div
                                                        class="form-group @error('address.postal_street_address') error @enderror">
                                                        <input type="text" class="form-control"
                                                            value="{{ old('address.postal_street_address', $address?->postal_street_address) }}"
                                                            name="address[postal_street_address]"
                                                            id="postalStreetAddress"
                                                            placeholder="{{ __('Street Name & Number') }}" required>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div
                                                        class="form-group @error('address.postal_suburb') error @enderror">
                                                        <input type="text" class="form-control"
                                                            name="address[postal_suburb]"
                                                            value="{{ old('address.postal_suburb', $address?->postal_suburb) }}"
                                                            id="postalSubRoad" placeholder="{{ __('Suburb') }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                    <div
                                                        class="form-group @error('address.postal_city') error @enderror">
                                                        <input type="text" class="form-control"
                                                            name="address[postal_city]"
                                                            value="{{ old('address.postal_city', $address?->postal_city) }}" id="postalCity"
                                                            placeholder="{{ __('City') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                    <div
                                                        class="form-group @error('address.postal_post_code') error @enderror">
                                                        <input type="number" class="form-control"
                                                            name="address[postal_post_code]" id="postalPostCode"
                                                            value="{{ old('address.postal_post_code', $address?->postal_post_code) }}"
                                                            placeholder="{{ __('Post Code') }}" required>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 mt-3">
                                                    <div
                                                        class="form-group @error('address.postal_latitude') error @enderror">
                                                        <input type="text" class="form-control" id="postalLatitude"
                                                            name="address[postal_latitude]"
                                                            value="{{ old('address.postal_latitude', $address?->postal_latitude) }}"
                                                            placeholder="{{ __('Latitude (optional)') }}">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 mt-3">
                                                    <div
                                                        class="form-group @error('address.postal_longitude') error @enderror">
                                                        <input type="text" class="form-control" id="postalLoggitude"
                                                            name="address[postal_longitude]"
                                                            value="{{ old('address.postal_longitude', $address?->postal_longitude) }}"
                                                            placeholder="{{ __('Longitude (optional)') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            @error('address.postal_street_address')
                                            <p class="error-message text-danger">{{ $message }}</p>
                                            @enderror
                                            @error('address.postal_suburb')
                                            <p class="error-message text-danger">{{ $message }}</p>
                                            @enderror
                                            @error('address.postal_city')
                                            <p class="error-message text-danger">{{ $message }}</p>
                                            @enderror
                                            @error('address.postal_post_code')
                                            <p class="error-message text-danger">{{ $message }}</p>
                                            @enderror
                                            @error('address.postal_latitude')
                                            <p class="error-message text-danger">{{ $message }}</p>
                                            @enderror
                                            @error('address.postal_longitude')
                                            <p class="error-message text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group row @error('user.avatar') error @enderror p-sm-3">
                            <label class="col-sm-3 col-form-label">Avatar</label>
                            <div class="col-sm-9">
                                <div class="file-upload-section">
                                    <input name="user[avatar]" type="file" class="form-control d-none"
                                        allowed="png,gif,jpeg,jpg">
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info" disabled="" readonly
                                            placeholder="Size: 200x200 and max 500kB">
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-outline-secondary"
                                                type="button"><i class="fas fa-upload"></i>
                                                Browse</button>
                                        </span>
                                    </div>
                                    @error('user.avatar')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                    <div class="display-input-image"
                                        style="display: {{ $user->avatar ? '' : 'd-none' }}">
                                        <img src="{{ $user->getAvatar() }}" alt="Preview Image" />
                                        <button type="button"
                                            class="btn btn-sm btn-outline-danger file-upload-remove ml-3"
                                            title="Remove">x</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="modal-footer justify-content-center col-md-12">
                        {!! \App\Library\Html::btnSubmit() !!}
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>


@stop

@include('admin.assets.datetimepicker')

@push('scripts')
<script>
    $(document).ready(function () {
        $("#sameAddress").on("change", function(){
            if (this.checked) {
                $("#postalStreetAddress").val($("#homeStreetAddress").val());
                $("#postalSubRoad").val($("#homeSubRoad").val());
                $("#postalCity").val($("#homeCity").val());
                $("#postalPostCode").val($("#homePostCode").val());
                $("#postalLatitude").val($("#homeLatitude").val());
                $("#postalLoggitude").val($("#homeLoggitude").val());
            } else {
                $("#postalStreetAddress").val('');
                $("#postalSubRoad").val('');
                $("#postalCity").val('');
                $("#postalPostCode").val('');
                $("#postalLatitude").val('');
                $("#postalLoggitude").val('');
            }
        });
    });
  </script>
@endpush
