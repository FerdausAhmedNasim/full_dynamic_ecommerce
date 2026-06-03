@extends('admin.layouts.master')
@section('title', __('New Seller'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.user.seller.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('New Seller')) }}</h4>
        </div>
    </div>

    <form method="post" action="{{ route('admin.user.seller.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body py-sm-4">

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group row @error('user.first_name') error @enderror">
                                    <label class="col-sm-12 required">{{ __('First Name') }}</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="user[first_name]"
                                            value="{{ old('user.first_name') }}" placeholder="{{ __('First Name') }}"
                                            required>
                                        @error('user.first_name')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row @error('user.last_name') error @enderror">
                                    <label class="col-sm-12">{{ __('Last Name') }}
                                        <span class="fw-lighter text-smaller">(optional)</span>
                                    </label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="user[last_name]"
                                            value="{{ old('user.last_name') }}" placeholder="{{ __('Last Name') }}">
                                        @error('user.last_name')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                        <div class="col-md-6">
                                <div class="form-group row @error('mobile') error @enderror">
                                    <label class="col-sm-12 required">{{ __('Phone Number') }}</label>
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <select name="user[country_code]"
                                                    class="input-group-text text-secondary" required>
                                                    @foreach ($countries as $key => $country)
                                                    <option value="{{ old('user.country_code', $country['code']) }}"
                                                        {{ $key == 'BD' ? 'selected' : '' }}>
                                                        {{ $key }}
                                                        {{ $country['code'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
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
                            </div>
                            <div class="col-sm-6">
                        <div class="form-group row @error('user.email') error @enderror">
                            <label class="col-sm-12">{{ __('Email') }}
                                <span class="fw-lighter text-smaller">(optional)</span>
                            </label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control" name="user[email]"
                                    value="{{ old('user.email') }}" placeholder="{{ __('example@example.com') }}">
                                @error('user.email')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row @error('user.password') error @enderror">
                                    <label class="col-sm-12 required">{{ __('Password') }}</label>
                                    <div class="col-sm-12">
                                        <input type="password" class="form-control" name="user[password]"
                                            value="{{ old('user.password') }}" placeholder="{{ __('Password') }}"
                                            required>
                                        @error('user.password')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row @error('user.password_confirmation') error @enderror">
                                    <label class="col-sm-12 required">{{ __('Confirm Password') }}</label>
                                    <div class="col-sm-12">
                                        <input type="password" class="form-control" name="user[password_confirmation]"
                                            value="{{ old('user.password_confirmation') }}"
                                            placeholder="{{ __('Confirm Password') }}" required>
                                        @error('user.password_confirmation')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row @error('user.gender') error @enderror">
                                    <label class="col-sm-12" for="name">{{ __('Gender') }}</label>
                                    <div class="col-sm-12">
                                        <select class="select form-control" name="user[gender]" id="gender"
                                            style="width: 100%;">
                                            <option value="" selected disabled>Select One</option>
                                            @foreach ($genders as $gender)
                                            <option value="{{ $gender }}"
                                                {{ old('user.gender') == $gender ? 'selected' : '' }}>
                                                {{ $gender }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('user.gender')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row @error('user.dob') error @enderror">
                                    <label class="col-sm-12" for="name">{{ __('Date Of Birth') }}</label>
                                    <div class="col-sm-12">

                                        <div class="input-group with-icon">
                                            <input type="text" name="user[dob]" id="dob"
                                                class="form-control datepicker-max-today" value="{{ old('user.dob') }}"
                                                placeholder="{{ settings('date_format') }}">
                                            <i class="date-icon fa-solid fa-calendar-days"></i>
                                        </div>
                                        @error('user.gender')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row @error('role_id') error @enderror" id="role">
                            <label
                                class="col-sm-12 required">{{ __('Role') }}</label>
                            <div class="col-sm-12">
                                <select class="form-control select2"  name="role_id[]" id="role_id"
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

                        <div class="form-group row @error('user.address') error @enderror">
                            <label class="col-sm-12">{{ __('Address') }}</label>
                            <div class="col-sm-12">
                                <textarea type="text" class="form-control" name="user[address]"
                                    value="{{ old('user.address') }}" placeholder="{{ __('Address') }}"></textarea>
                                @error('user.address')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row @error('user.avatar') error @enderror">
                            <label class="col-sm-12 ">Avatar</label>
                            <div class="col-sm-12">
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
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body py-sm-4">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row @error('store_lan.store_name') error @enderror">
                                    <label class="col-sm-12 required">{{ __('Store Name') }}</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="store_lan[store_name]"
                                            value="{{ old('store_lan.store_name') }}" placeholder="{{ __('Store Name') }}"
                                            required>
                                        @error('store_lan.store_name')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row @error('store.license_no') error @enderror">
                                    <label class="col-sm-12">{{ __('License Number') }}</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="store[license_no]"
                                            value="{{ old('store.license_no') }}" placeholder="{{ __('LNC-1133') }}">
                                        @error('store.license_no')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row @error('store_lan.store_tagline') error @enderror">
                            <label class="col-sm-12 required">{{ __('Store Tagline') }}</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="store_lan[store_tagline]"
                                    value="{{ old('store_lan.store_tagline') }}" placeholder="{{ __('Store Tagline') }}" required>
                                @error('store_lan.store_tagline')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row @error('store_lan.address') error @enderror">
                            <label class="col-sm-12">{{ __('Address') }}</label>
                            <div class="col-sm-12">
                                <textarea type="text" class="form-control" name="store_lan[address]"
                                    placeholder="{{ __('Address') }}">{{ old('store_lan.address') }}</textarea>
                                @error('store_lan.address')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row @error('store.logo') error @enderror">
                            <label class="col-sm-12 required">Logo (72*72)</label>
                            <div class="col-sm-12">
                                <div class="file-upload-section">
                                    <input name="store[logo]" type="file" class="form-control hidden-file"
                                        allowed="png,gif,jpeg,jpg" required>
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info" disabled="" readonly
                                            placeholder="Size: 200x200 and max 500kB">
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-outline-secondary"
                                                type="button"><i class="fas fa-upload"></i>
                                                Browse</button>
                                        </span>
                                    </div>
                                    @error('store_lan.logo')
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

                        <div class="form-group row @error('store.banner') error @enderror">
                            <label class="col-sm-12">Store Page Banner(850*480)</label>
                            <div class="col-sm-12">
                                <div class="file-upload-section">
                                    <input name="store[banner]" type="file" class="form-control d-none"
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
                                    @error('store.banner')
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

                        <div class="form-group row @error('store.facebook') error @enderror">
                            <label class="col-sm-12">{{ __('Facebook') }}</label>
                            <div class="col-sm-12">
                                <input type="url" class="form-control" name="store[facebook]" value="{{ old('store.facebook') }}"
                                    placeholder="{{ __('https://www.facebook.com/example') }}">
                                @error('facebook')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row @error('store.google') error @enderror">
                            <label class="col-sm-12">{{ __('Google') }}</label>
                            <div class="col-sm-12">
                                <input type="url" class="form-control" name="store[google]" value="{{ old('store.google') }}"
                                    placeholder="{{ __('https://www.google.com/example') }}">
                                @error('google')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row @error('store.twitter') error @enderror">
                            <label class="col-sm-12">{{ __('Twitter') }}</label>
                            <div class="col-sm-12">
                                <input type="url" class="form-control" name="store[twitter]" value="{{ old('store.twitter') }}"
                                    placeholder="{{ __('https://twitter.com/example') }}">
                                @error('twitter')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row @error('store.instagram') error @enderror">
                            <label class="col-sm-12">{{ __('Instagram') }}</label>
                            <div class="col-sm-12">
                                <input type="url" class="form-control" name="store[instagram]" value="{{ old('store.instagram') }}"
                                    placeholder="{{ __('https://www.instagram.com/example') }}">
                                @error('instagram')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row @error('store.youtube') error @enderror">
                            <label class="col-sm-12">{{ __('Youtube') }}</label>
                            <div class="col-sm-12">
                                <input type="url" class="form-control" name="store[youtube]" value="{{ old('store.youtube') }}"
                                    placeholder="{{ __('https://www.youtube.com/example') }}">
                                @error('youtube')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row @error('store_lan.meta_title') error @enderror">
                            <label class="col-sm-12">{{ __('Meta Title') }}</label>
                            <div class="col-sm-12">
                                <input type="test" class="form-control" name="store_lan[meta_title]"
                                    value="{{ old('store_lan.meta_title') }}" placeholder="{{ __('Meta Name') }}">
                                @error('store_lan.meta_title')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row @error('store_lan.meta_description') error @enderror">
                            <label class="col-sm-12">{{ __('Meta Description') }}</label>
                            <div class="col-sm-12">
                                <textarea type="text" class="form-control" name="store_lan[meta_description]"
                                    placeholder="{{ __('Meta Description') }}">{{ old('store_lan.meta_description') }}</textarea>

                                @error('store_lan.meta_description')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="modal-footer justify-content-center col-md-12">
                                {!! \App\Library\Html::btnReset() !!}
                                {!! \App\Library\Html::btnSubmit() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@stop

@include('admin.assets.select2')
@include('admin.assets.datetimepicker')

@push('scripts')
@vite('resources/admin_assets/js/select2.js')
@endpush