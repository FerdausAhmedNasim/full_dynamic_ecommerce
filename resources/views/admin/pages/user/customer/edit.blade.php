@extends('admin.layouts.master')

@section('title', __('Update Customer'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.user.customer.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update Customer')) }}</h4>
        </div>

    </div>

    <div class="card shadow-sm">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.user.customer.update', $user->id) }}"
                enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="id" value="{{ $user->id }}" />
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-sm-3">

                            <div class="form-group row @error('full_name') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Full Name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="full_name"
                                        value="{{ old('full_name', $user->full_name) }}" placeholder="{{ __('Full Name') }}"
                                        required>
                                    @error('full_name')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('email') error @enderror">
                                <label class="col-sm-3 col-form-label">{{ __('Email') }}</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="email"
                                        value="{{ old('email', $user->email) }}" placeholder="{{ __('example@example.com') }}">
                                    @error('email')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('gender') error @enderror">
                                <label class="col-sm-3 col-form-label" for="name">{{ __('Gender')
                                    }}</label>
                                <div class="col-sm-9">
                                    <select class="select form-control" name="gender" id="gender"
                                        style="width: 100%;">
                                        <option value="" selected disabled>Select One</option>
                                        @foreach($genders as $gender)
                                        <option value="{{ $gender }}" {{ old('gender', $user->gender) == $gender
                                            ? "selected" : "" }} data-params="{{ $gender }}">
                                            {{ $gender }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('Address') }}</label>
                            <div class="col-sm-9">
                                <textarea type="text" class="form-control" name="address" value="{{ old('address', $user->address) }}"
                                    placeholder="{{ __('Address') }}"></textarea>
                            </div>
                        </div>

                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('Description') }}</label>
                            <div class="col-sm-9">
                                <textarea type="text" class="form-control" name="description" value="{{ old('description', $user->description) }}"
                                    placeholder="{{ __('Description') }}"></textarea>
                            </div>
                        </div>

                        <div class="form-group row @error('mobile') error @enderror">
                            <label class="col-sm-3 col-form-label required">{{ __('Mobile No') }}</label>
                            <div class="col-sm-9">
                                <div class="input-group mb-4">
                                    {{-- <div class="input-group-prepend">
                                        <select name="country_code" class="input-group-text text-primary"
                                            required>
                                            @foreach($countries as $key => $country)
                                            <option value="{{ old('country_code', $country['code']) }}"
                                                {{ ($country['code'] == ($user ? (explode('-', $user->phone))[0] : "+880")) ? "selected" : "" }}>
                                                {{$key}} {{ $country['code']}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <input type="number" name="phone"
                                        value="{{ old('phone', $user->phone) }}"
                                        class="form-control" placeholder="{{ __('013 355 666') }}" required>

                                </div>
                                @error('phone')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row @error('dob') error @enderror">
                            <label class="col-sm-3 col-form-label" for="name">{{ __('Date Of
                                Birth') }}</label>
                            <div class="col-sm-9">

                                <div class="input-group with-icon">
                                    <input type="text" name="dob" id="dob"
                                        class="form-control datepicker-max-today"
                                        value="{{ old('dob', getFormattedDate($user->dob)) }}" placeholder="{{ settings('date_format') }}" >
                                    <i class="date-icon fa-solid fa-calendar-days"></i>
                                </div>

                                @error('dob')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                                <span class="error-message text-danger" id="error-dob"></span>
                            </div>
                        </div>

                        <div class="form-group row @error('avatar') error @enderror">
                            <label class="col-sm-3 col-form-label">Avatar</label>
                            <div class="col-sm-9">
                                <div class="file-upload-section">
                                    <input name="avatar" type="file" class="form-control d-none"
                                        allowed="png,gif,jpeg,jpg">
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info"
                                            disabled="" readonly
                                            placeholder="Size: 200x200 and max 500kB">
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-outline-secondary"
                                                type="button"><i class="fas fa-upload"></i>
                                                Browse</button>
                                        </span>
                                    </div>
                                    @error('avatar')
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
                        {!! \App\Library\Html::btnReset() !!}
                        {!! \App\Library\Html::btnSubmit() !!}
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@include('admin.assets.select2')
@include('admin.assets.datetimepicker')

@push('scripts')
@vite('resources/admin_assets/js/select2.js')
@endpush
