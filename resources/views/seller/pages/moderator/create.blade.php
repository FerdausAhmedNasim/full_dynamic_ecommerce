@extends('seller.layouts.master')

@section('title', __('New Moderator'))

@section('content')

    <div class="content-wrapper container-fluid">

        <div class="content-header d-flex justify-content-start">
            {!! \App\Library\Html::linkBack(route('seller.moderator.index')) !!}
            <div class="d-block">
                <h4 class="content-title">{{ strtoupper(__('New Moderator')) }}</h4>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-11 col-sm-10 col-md-10 col-lg-6 col-xl-12 text-center p-0 mt-1 mb-2">
                <div class="card px-5 pt-4 pb-1 mt-3 mb-3 shadow-lg main">

                    <form method="post" action="{{ route('seller.moderator.create') }}" id="msform"
                        enctype="multipart/form-data">
                        @csrf

                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div>{{$error}}</div>
                            @endforeach
                        @endif

                        <!-- progressbar -->
                        <ul id="progressbar">
                            <li class="active process-w5" id="account">
                                <i class="fa-solid fa-user"></i>
                                <strong>Personal</strong>
                            </li>

                            <li class="process-w5" id="address">
                                <i class="fa-solid fa-location-dot"></i>
                                <strong>Address</strong>
                            </li>

                            <li class="process-w5" id="payment">
                                <i class="fa-regular fa-address-book"></i>
                                <strong>Emergency Contact</strong>
                            </li>

                            <li class="process-w5" id="payment">
                                <i class="fa-solid fa-unlock"></i>
                                <strong>Security</strong>
                            </li>

                            <li class="process-w5" id="confirm">
                                <i class="fa-solid fa-check"></i>
                                <strong>Finish</strong>
                            </li>

                        </ul>

                        <br>

                        {{-- Start Personal Form --}}
                        <fieldset>
                            <div class="form-card">
                                <div class="row">
                                    <div class="col-7">
                                        <h2 class="fs-title">Personal Information:</h2>
                                    </div>
                                    <div class="col-5">
                                        <h2 class="steps">Step 1 - 5</h2>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="p-sm-3">

                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label required">{{ __('Moderator Name') }}</label>
                                                <div class="col-sm-9">
                                                    <div class="row">
                                                        <div class="col-xl-6 col-md-12 col-sm-12">
                                                            <div class="form-group @error('user.first_name') error @enderror">
                                                                <input type="text" class="form-control" id="fname"
                                                                    value="{{ old('user.first_name') }}" name="user[first_name]"
                                                                    placeholder="{{ __('First Name') }}" required>

                                                                <span class="error-message text-danger"
                                                                    id="error-fname"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6 col-md-12 col-sm-12">
                                                            <div class="form-group @error('user.last_name') error @enderror">
                                                                <input type="text" class="form-control"
                                                                    name="user[last_name]" value="{{ old('user.last_name') }}"
                                                                    id="lname" placeholder="{{ __('Last Name') }}"
                                                                    required>

                                                                <span class="error-message text-danger"
                                                                    id="error-lname"></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @error('user.first_name')
                                                        <p class="error-message text-danger">{{ $message }}</p>
                                                    @enderror

                                                    @error('user.last_name')
                                                        <p class="error-message text-danger">{{ $message }}</p>
                                                    @enderror

                                                </div>
                                            </div>

                                            <div class="form-group row @error('user.email') error @enderror">
                                                <label
                                                    class="col-sm-3 col-form-label required">{{ __('Work Email') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="email" class="form-control" name="user[email]"
                                                        value="{{ old('user.email') }}" id="workEmail"
                                                        placeholder="{{ __('Email Address') }}" required>
                                                    @error('user.email')
                                                        <p class="error-message">{{ $message }}</p>
                                                    @enderror
                                                    <span class="error-message text-danger" id="error-workEmail"></span>
                                                </div>
                                            </div>

                                            <div class="form-group row @error('mobile') error @enderror">
                                                <label
                                                    class="col-sm-3 col-form-label required">{{ __('Work Phone') }}</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        {{-- <div class="input-group-prepend">
                                                            <select name="user[country_code]"
                                                                class="input-group-text text-secondary" required>
                                                                @foreach ($countries as $key => $country)
                                                                    <option
                                                                        value="{{ old('user.country_code', $country['code']) }}"
                                                                        {{ $key == 'NZ' ? 'selected' : '' }}>
                                                                        {{ $key }}
                                                                        {{ $country['code'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div> --}}
                                                        <input type="number" name="user[phone]" id="workPhone"
                                                            value="{{ old('user.phone') }}" class="form-control"
                                                            placeholder="{{ __('013 355 666') }}" required>
                                                    </div>
                                                    @error('mobile')
                                                        <p class="error-message">{{ $message }}</p>
                                                    @enderror
                                                    <span class="error-message text-danger" id="error-workPhone"></span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label
                                                    class="col-sm-3 col-form-label required">{{ __('Password') }}</label>
                                                <div class="col-sm-9">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div
                                                                class="form-group @error('user.password') error @enderror">
                                                                <input type="password" class="form-control"
                                                                    id="pass" name="user[password]"
                                                                    placeholder="{{ __('Password') }}" required>

                                                                <span class="error-message text-danger"
                                                                    id="error-pass"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div
                                                                class="form-group @error('user.password_confirmation') error @enderror">
                                                                <input type="password" class="form-control"
                                                                    name="user[password_confirmation]" id="cpass"
                                                                    placeholder="{{ __('Confirm Password') }}" required>

                                                                <span class="error-message text-danger"
                                                                    id="error-cpass"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @error('user.password')
                                                        <p class="error-message text-danger">{{ $message }}</p>
                                                    @enderror
                                                    @error('user.password_confirmation')
                                                        <p class="error-message text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row @error('user.avatar') error @enderror">
                                                <label class="col-sm-3 col-form-label">Avatar</label>
                                                <div class="col-sm-9">
                                                    <div class="file-upload-section">
                                                        <input name="user[avatar]" type="file"
                                                            class="form-control d-none" allowed="png,gif,jpeg,jpg">
                                                        <div class="input-group col-xs-12">
                                                            <input type="text" class="form-control file-upload-info"
                                                                disabled="" readonly
                                                                placeholder="Size: 200x200 and max 500kB">
                                                            <span class="input-group-append">
                                                                <button
                                                                    class="file-upload-browse btn btn-outline-secondary"
                                                                    type="button"><i class="fas fa-upload"></i>
                                                                    Browse</button>
                                                            </span>
                                                        </div>
                                                        @error('user.avatar')
                                                            <p class="error-message">{{ $message }}</p>
                                                        @enderror
                                                        <div class="display-input-image d-none">
                                                            <img src="{{ Vite::asset(\App\Library\Enum::NO_IMAGE_PATH) }}"
                                                                alt="Preview Image" />
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-danger file-upload-remove ml-3"
                                                                title="Remove">x</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">

                                        <div class="p-sm-3">

                                            <div class="form-group row @error('user.dob') error @enderror">
                                                <label class="col-sm-3 col-form-label required"
                                                    for="name">{{ __('Date Of Birth') }} </label>
                                                <div class="col-sm-9">

                                                    <div class="input-group with-icon">
                                                        <input type="text" name="user[dob]" id="dob"
                                                            class="form-control datepicker-max-today"
                                                            value="{{ old('user.dob') }}" placeholder="{{ settings('date_format') }}" required >
                                                        <i class="date-icon fa-solid fa-calendar-days"></i>
                                                    </div>

                                                    @error('user.dob')
                                                        <p class="error-message">{{ $message }}</p>
                                                    @enderror
                                                    <span class="error-message text-danger" id="error-dob"></span>
                                                </div>
                                            </div>

                                            <div class="form-group row @error('user.gender') error @enderror">
                                                <label class="col-sm-3 col-form-label required"
                                                    for="name">{{ __('Gender') }}</label>
                                                <div class="col-sm-9">
                                                    <select class="select form-control" name="user[gender]"
                                                        id="gender" style="width: 100%;" required>
                                                        <option value="" selected disabled>Select One</option>
                                                        @foreach ($genders as $gender)
                                                            <option value="{{ $gender }}"
                                                                {{ old('user.gender') == $gender ? 'selected' : '' }}
                                                                data-params="{{ $gender }}">
                                                                {{ $gender }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('user.gender')
                                                        <p class="error-message">{{ $message }}</p>
                                                    @enderror
                                                    <span class="error-message text-danger" id="error-gender"></span>
                                                </div>
                                            </div>

                                            <div class="form-group row @error('employee.job_title') error @enderror">
                                                <label class="col-sm-3 col-form-label required"
                                                    for="name">{{ __('Job Title') }}</label>
                                                <div class="col-sm-9">

                                                    <select class="select form-control" name="employee[job_title]"
                                                        id="jobTitle" style="width: 100%;" required>
                                                        <option value="" selected disabled>Select One</option>
                                                        @foreach ($jobTitles as $jobTitle)
                                                            <option value="{{ $jobTitle }}"
                                                                {{ old('employee.job_title') == $jobTitle ? 'selected' : '' }}
                                                                data-params="{{ $jobTitle }}">
                                                                {{ $jobTitle }}</option>
                                                        @endforeach
                                                    </select>

                                                    @error('employee.job_title')
                                                        <p class="error-message">{{ $message }}</p>
                                                    @enderror
                                                    <span class="error-message text-danger" id="error-jobTitle"></span>

                                                </div>
                                            </div>

                                            <div class="form-group row @error('employee.employment_type') error @enderror">
                                                <label class="col-sm-3 col-form-label required required"
                                                    for="name">{{ __('Employment Type') }}</label>
                                                <div class="col-sm-9">

                                                    <select class="select form-control" name="employee[employment_type]"
                                                        id="employmentType" style="width: 100%;" required>
                                                        <option value="" selected disabled>Select One</option>
                                                        @foreach ($employmentTypes as $employmentType)
                                                            <option value="{{ $employmentType }}"
                                                                {{ old('employee.employment_type') == $employmentType ? 'selected' : '' }}
                                                                data-params="{{ $employmentType }}">
                                                                {{ $employmentType }}</option>
                                                        @endforeach
                                                    </select>

                                                    @error('employee.employment_type')
                                                        <p class="error-message">{{ $message }}</p>
                                                    @enderror
                                                    <span class="error-message text-danger"
                                                        id="error-employmentType"></span>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input type="button" name="next" class="fs_next_btn action-button" value="Next" />

                        </fieldset>
                        {{-- End Personal Form --}}

                        {{-- Start Address Form --}}
                        <fieldset>
                            <div class="form-card">
                                <div class="row">
                                    <div class="col-7">
                                        <h2 class="fs-title">Address:</h2>
                                    </div>
                                    <div class="col-5">
                                        <h2 class="steps">Step 3 - 5</h2>
                                    </div>
                                </div>
                                @include('admin.pages.address.create')
                            </div>

                            <input type="button" name="next" class="ts_next_btn action-button" id="addressNext"
                                value="Next" />
                            <input type="button" name="previous" class="previous action-button-previous"
                                value="Previous" />

                        </fieldset>
                        {{-- End Address Form --}}


                        {{-- Start Emergency Contact Form --}}
                        <fieldset>
                            <div class="form-card">
                                <div class="row">
                                    <div class="col-7">
                                        <h2 class="fs-title">Emergency Contact:</h2>
                                    </div>
                                    <div class="col-5">
                                        <h2 class="steps">Step 4 - 5</h2>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="p-sm-3">

                                            <div class="form-group row @error('emergencyContact.name') error @enderror">
                                                <label
                                                    class="col-sm-3 col-form-label required">{{ __('Name') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control"
                                                        name="emergencyContact[name]" id="emergencyContactName"
                                                        value="{{ old('emergencyContact.name') }}"
                                                        placeholder="{{ __('Name') }}" required>
                                                    @error('emergencyContact.name')
                                                        <p class="error-message">{{ $message }}</p>
                                                    @enderror
                                                    <span class="error-message text-danger"
                                                        id="error-emergencyContactName"></span>
                                                </div>
                                            </div>

                                            <div class="form-group row @error('emergencyContact.email') error @enderror">
                                                <label class="col-sm-3 col-form-label">{{ __('Email') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="email" class="form-control"
                                                        name="emergencyContact[email]"
                                                        value="{{ old('emergencyContact.email') }}"
                                                        placeholder="{{ __('Email Address') }}">
                                                    @error('emergencyContact.email')
                                                        <p class="error-message">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row @error('emergencyContact.mobile_number') error @enderror">
                                                <label
                                                    class="col-sm-3 col-form-label required">{{ __('Mobile') }}</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group mb-4">
                                                        {{-- <div class="input-group-prepend">
                                                            <select name="emergencyContact[country_code]"
                                                                class="input-group-text text-secondary" required>
                                                                @foreach ($countries as $key => $country)
                                                                    <option
                                                                        value="{{ old('emergencyContact.country_code', $country['code']) }}"
                                                                        {{ $key == 'NZ' ? 'selected' : '' }}>
                                                                        {{ $key }}
                                                                        {{ $country['code'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div> --}}
                                                        <input type="number" name="emergencyContact[mobile_number]"
                                                            id="emergencyContactMobile"
                                                            value="{{ old('emergencyContact.mobile_number') }}"
                                                            class="form-control" placeholder="{{ __('013 355 666') }}"
                                                            required>
                                                    </div>
                                                    @error('emergencyContact.mobile_number')
                                                        <p class="error-message">{{ $message }}</p>
                                                    @enderror
                                                    <span class="error-message text-danger"
                                                        id="error-emergencyContactMobile"></span>
                                                </div>
                                            </div>

                                            <div
                                                class="form-group row @error('emergencyContact.relationship') error @enderror">
                                                <label
                                                    class="col-sm-3 col-form-label required">{{ __('Relationship') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control"
                                                        name="emergencyContact[relationship]"
                                                        value="{{ old('emergencyContact.relationship') }}"
                                                        id="emergencyContactRelationship"
                                                        placeholder="{{ __('Ex: Brother, Sister, Father') }}" required>
                                                    @error('emergencyContact.relationship')
                                                        <p class="error-message">{{ $message }}</p>
                                                    @enderror
                                                    <span class="error-message text-danger"
                                                        id="error-emergencyContactRelationship"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="p-sm-3">

                                            <div
                                                class="form-group row @error('emergencyContact.address') error @enderror">
                                                <label class="col-sm-3 col-form-label"
                                                    for="name">{{ __('Address') }}</label>
                                                <div class="col-sm-9">
                                                    <textarea type="text" name="emergencyContact[address]" class="form-control"
                                                        placeholder="{{ __('Write Your Address') }}" rows="4">{{ old('emergencyContact.address') }}</textarea>
                                                    @error('emergencyContact.address')
                                                        <p class="error-message">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row @error('emergencyContact.note') error @enderror">
                                                <label class="col-sm-3 col-form-label"
                                                    for="note">{{ __('Note') }}</label>
                                                <div class="col-sm-9">
                                                    <textarea type="text" name="emergencyContact[note]" class="form-control"
                                                        placeholder="{{ __('Write About You') }}" rows="4">{{ old('emergencyContact.note') }}</textarea>
                                                    @error('emergencyContact.note')
                                                        <p class="error-message">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <input type="button" name="next" class="eg_next_btn action-button" id="emergencyNext"
                                value="Next" />
                            <input type="button" name="previous" class="previous action-button-previous"
                                value="Previous" />

                        </fieldset>
                        {{-- End Emergency Contact Form --}}

                        {{-- Start Security Form --}}
                        <fieldset>
                            <div class="form-card">
                                <div class="row">
                                    <div class="col-7">
                                        <h2 class="fs-title">Security:</h2>
                                    </div>
                                    <div class="col-5">
                                        <h2 class="steps">Step 5 </h2>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="p-sm-3">
                                            {{-- <div class="form-group row">
                                                <label class="col-sm-3 col-form-label required required">{{ __('Access To') }}</label>
                                                <div class="col-sm-9">
                                                    <div class="d-inline-flex justify-content-start">
                                                        <div class="form-check form-check-secondary mr-5">
                                                            <label class="form-check-label">
                                                                <input type="radio" id="userAccessTypeAdmin"
                                                                    class="form-check-input user-type-radio"
                                                                    name="user[user_type]"
                                                                    value="{{ App\Library\Enum::USER_TYPE_ADMIN }}"
                                                                    required
                                                                    {{ !old('user.user_type') || old('user.user_type') == App\Library\Enum::USER_TYPE_ADMIN ? 'checked' : '' }}>
                                                                Admin Interface
                                                                <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-secondary">
                                                            <label class="form-check-label">
                                                                <input type="radio" id="userAccessTypeModerator"
                                                                    class="form-check-input user-type-radio"
                                                                    name="user[user_type]"
                                                                    value="{{ App\Library\Enum::USER_TYPE_EMPLOYEE }}"
                                                                    required
                                                                    {{ old('user.user_type') && old('user.user_type') == App\Library\Enum::USER_TYPE_EMPLOYEE ? 'checked' : '' }}>
                                                                Moderator / App interface
                                                                <i class="input-helper"></i></label>
                                                        </div>
                                                        @error('user.user_type')
                                                            <p class="error-message text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <div class="form-group row @error('role_id') error @enderror" id="role">
                                                <label
                                                    class="col-sm-3 col-form-label required">{{ __('Role') }}</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control select2" name="role_id[]" id="role_id"
                                                        multiple>
                                                        @foreach ($roles as $value)
                                                            <option value="{{ $value->id }}"
                                                                {{ collect(old('role_id'))->contains($value->id) ? 'selected' : '' }}
                                                                data-params="{{ $value->id }}">
                                                                {{ ucwords($value->name) }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('role_id')
                                                        <p class="error-message">{{ $message }}</p>
                                                    @enderror
                                                    <span class="error-message text-danger" id="error-role_id"></span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <input type="submit" name="next" class="submit action-button tse_next_btn"
                                id="securitySubmit" value="Submit" />
                            <input type="button" name="previous" class="previous action-button-previous"
                                value="Previous" />

                        </fieldset>
                        {{-- End Security Form --}}

                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@include('admin.assets.select2')
@include('admin.assets.datetimepicker')

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.0/jquery.easing.js" type="text/javascript">
    </script>

    {{-- @vite('resources/admin_assets/js/jquery.easing.js') --}}
    @vite('resources/seller_assets/js/pages/moderator/create.js')
@endpush
