@extends('admin.layouts.master')
@section('title', __('New Payment'))

@section('content')

    <div class="content-wrapper container-fluid">

        <div class="content-header d-flex justify-content-start">
            {!! \App\Library\Html::linkBack(route('admin.payment.index')) !!}
            <div class="d-block">
                <h4 class="content-title">{{ strtoupper(__('New Payment')) }}</h4>
            </div>
        </div>


        <div class="row justify-content-center">
            <div class="col-11 col-sm-10 col-md-10 col-lg-6 col-xl-12 text-center p-0 mt-1">
                <div class="card px-3 pt-4 shadow-sm main" style="box-shadow: 0px 2px 5px #005C2D!important;">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="p-sm-3">

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label required required">{{ __('Payment Type') }} </label>
                                    <div class="col-sm-9">
                                        <div class="d-inline-flex justify-content-start">
                                            <div class="form-check form-check-secondary mr-5">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input payment-type-radio"
                                                        name="payment_type" value="1" required
                                                        {{ !old('payment_type') || old('payment_type') == '1' ? 'checked' : '' }}>
                                                    Tournament
                                                    <i class="input-helper"></i></label>
                                            </div>

                                            <div class="form-check form-check-secondary ">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input payment-type-radio"
                                                        name="payment_type" value="2" required
                                                        {{ old('payment_type') == '2' ? 'checked' : '' }}>
                                                    Subscription
                                                    <i class="input-helper"></i></label>
                                            </div>

                                            @error('payment_type')
                                                <p class="error-message text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-11 col-sm-10 col-md-10 col-lg-6 col-xl-12 p-0 mt-1 mb-2">

                <!-- Tournament ---->
                <div id="tournament" class="card px-5 pt-4 pb-1 mt-3 mb-3 shadow-sm"
                    style="box-shadow: 0px 2px 5px #005C2D!important;">
                    <form method="post" action="{{ route('admin.boat.create') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="p-sm-3">

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label required required">{{ __('Join As') }} </label>
                                        <div class="col-sm-9">
                                            <div class="d-inline-flex justify-content-start">
                                                <div class="form-check form-check-secondary mr-5">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input user-type-radio"
                                                            name="owner_is_member" value="1" required
                                                            {{ !old('owner_is_member') || old('owner_is_member') == '1' ? 'checked' : '' }}>
                                                        Member
                                                        <i class="input-helper"></i></label>
                                                </div>

                                                <div class="form-check form-check-secondary ">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input user-type-radio"
                                                            name="owner_is_member" value="2" required
                                                            {{ old('owner_is_member') == '2' ? 'checked' : '' }}>
                                                        Captain
                                                        <i class="input-helper"></i></label>
                                                </div>

                                                @error('owner_is_member')
                                                    <p class="error-message text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row @error('tournament_id') error @enderror @if(old('owner_is_member') == 2) d-none @endif" id="member_id_div">
                                        <label class="col-sm-3 col-form-label required">{{ __('Tournament') }}</label>
                                        <div class="col-sm-9">
                                            <select class="form-control select2" name="tournament_id" id="tournament_id" required>
                                                <option value="" class="selected highlighted">Select One</option>
                                                @foreach($tournaments as $tournament)
                                                <option value="{{ $tournament->id }}"
                                                    {{(old("tournament_id") == $tournament->id) ? "selected" : ""}}>
                                                    {{ $tournament->tournament_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('tournament_id')
                                            <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <p>Tournament Description: </p>
                                    </div>

                                    <div class="form-group row @error('team_id') error @enderror " id="member_id_div">
                                        <label class="col-sm-3 col-form-label required">{{ __('Team') }}</label>
                                        <div class="col-sm-9">
                                            <select class="form-control select2" name="team_id" id="team_id" required>
                                                <option value="" class="selected highlighted">Select One</option>
                                                @foreach($teams as $team)
                                                <option value="{{ $tournament->id }}"
                                                    {{(old("team_id") == $team->id) ? "selected" : ""}}>
                                                    {{ $team->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('team_id')
                                            <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                
                                    </div>

                                    <div class="form-group row @error('member_id') error @enderror @if(old('owner_is_member') == 2) d-none @endif" id="member_id_div">
                                        <label class="col-sm-3 col-form-label required">{{ __('Member') }}</label>
                                        <div class="col-sm-9">
                                            <select class="form-control select2" name="member_id[]" id="member_id" multiple required>
                                                <option value="" class="selected highlighted">Select One</option>
                                                @foreach($tournaments as $tournament)
                                                <option value="{{ $tournament->id }}"
                                                    {{(old("member_id") == $tournament->id) ? "selected" : ""}}>
                                                    {{ $tournament->tournament_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('member_id')
                                            <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row @error('owner_name') error @enderror " id="owner_name_div">
                                        <label class="col-sm-3 col-form-label required">{{ __('Amount') }}</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="owner_name" id="owner_name"
                                                value="{{ old('owner_name') }}" placeholder="{{ __('Ex:100') }}">
                                            @error('owner_name')
                                            <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row @error('registration_number') error @enderror">
                                        <label class="col-sm-3 col-form-label required">{{ __('Registration Number') }}</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="registration_number"
                                                value="{{ old('registration_number') }}" placeholder="{{ __('Ex: xyz123455') }}"
                                                required>
                                            @error('registration_number')
                                            <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row @error('short_description') error @enderror">
                                        <label class="col-sm-3 col-form-label">{{ __('Short Description') }}</label>
                                        <div class="col-sm-9">
                                            <textarea type="text" class="form-control" name="short_description"
                                                placeholder="{{ __('Write Short Description.......') }}">{{ old('short_description') }}</textarea>
                                            @error('short_description')
                                            <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row @error('image') error @enderror">
                                        <label class="col-sm-3 col-form-label">Image</label>
                                        <div class="col-sm-9">
                                            <div class="file-upload-section">
                                                <input name="image" type="file" class="form-control d-none"
                                                    allowed="png,gif,jpeg,jpg">
                                                <div class="input-group col-xs-12">
                                                    <input type="text" class="form-control file-upload-info" disabled=""
                                                        readonly placeholder="Size: 600x600 and max 800kB">
                                                    <span class="input-group-append">
                                                        <button class="file-upload-browse btn btn-outline-secondary"
                                                            type="button"><i class="fas fa-upload"></i>
                                                            Browse</button>
                                                    </span>
                                                </div>
                                                @error('image')
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

                                    <div class="form-group row @error('short_description') error @enderror">
                                        <label class="col-sm-3 col-form-label">{{ __('Description') }}</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="summernote"
                                                name="description">{{ old('description') }}</textarea>
                                            @error('short_description')
                                            <p class="error-message">{{ $message }}</p>
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
                </div>

                <!-- Subscription ---->
                <div id="subscription" class="card px-5 pt-4 pb-1 mt-3 mb-3 shadow-sm main d-none"
                    style="box-shadow: 0px 2px 5px #005C2D!important;">
                    <form method="post" action="{{ route('admin.fish_species.create') }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="p-sm-3">

                            <div class="form-group row @error('name') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Subscription') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name') }}" placeholder="{{ __('Name') }}" required>
                                    @error('name')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('type') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Type') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="type" id="type" required>
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach ($fish_types ?? [] as $key => $fish_type)
                                            <option value="{{ $key }}"
                                                {{ old('type') == $key ? 'selected' : '' }}>
                                                {{ $fish_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row d-none @error('point') error @enderror" id="point_div">
                                <label class="col-sm-3 col-form-label required">{{ __('Point') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" step="0.1" name="point"
                                        id="point" value="{{ old('point') }}" placeholder="{{ __('Ex:1.5') }}">
                                    @error('point')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="description">{{ __('Description') }}</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="summernote" name="description">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row @error('image') error @enderror">
                                <label class="col-sm-3 col-form-label" for="description">{{ __('Image') }}</label>
                                <div class="col-sm-9">
                                    <div class="file-upload-section">
                                        <input name="image" type="file" class="form-control hidden_file"
                                            allowed="png,gif,jpeg,jpg">
                                        <div class="input-group col-xs-12">
                                            <input type="text"
                                                class="form-control file-upload-info @error('image') error @enderror"
                                                disabled="" readonly placeholder="Size: 200x200 and max 200kB">
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-outline-secondary"
                                                    type="button"><i class="fas fa-upload"></i> Browse</button>
                                            </span>

                                        </div>
                                        <div class="display-input-image d-none">
                                            <img src="{{ asset(\App\Library\Enum::NO_IMAGE_PATH) }}"
                                                alt="Preview Image" />
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger file-upload-remove"
                                                title="Remove">x</button>
                                        </div>
                                        @error('image')
                                            <p class="error-message text-danger">{{ $message }}</p>
                                        @enderror
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

        </form>
    </div>
@stop
@include('admin.assets.select2')
@include('admin.assets.datetimepicker')

@push('scripts')
    @vite('resources/admin_assets/js/pages/payment/create.js')

    <script>
        $(document).ready(function() {
            $('#time_of_hook_up').val("");
            $('#time_of_hook_up').on('cancel.daterangepicker', function(ev, picker) {
                $('#time_of_hook_up').val("");
            });

            $('#boated_time').val("");
            $('#boated_time').on('cancel.daterangepicker', function(ev, picker) {
                $('#boated_time').val("");
            });
        });
    </script>
@endpush
